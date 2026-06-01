<?php
namespace MiCatalogo;

class Limits {
    public function __construct() {
        add_action( 'wp_insert_post_data', [ $this, 'check_product_limits' ], 10, 2 );
        add_filter( 'wp_handle_upload_prefilter', [ $this, 'check_image_limits' ] );
    }

    public function check_product_limits( $data, $postarr ) {
        // Solo aplica si se está publicando un producto del catálogo
        if ( $data['post_type'] !== 'micatalogo_product' || $data['post_status'] !== 'publish' ) {
            return $data;
        }

        $user_id = get_current_user_id();
        if ( ! in_array( 'vendor', (array) get_userdata( $user_id )->roles ) ) {
            return $data;
        }

        // Obtener plan actual
        $plan_id = get_user_meta( $user_id, 'micatalogo_plan', true ) ?: 'basic';
        $billing = new SaaS_Billing();
        $plans = $billing->get_plans();
        $limit = isset($plans[$plan_id]['limit']) ? $plans[$plan_id]['limit'] : 10;

        // Si es ilimitado
        if ( $limit === -1 ) {
            return $data;
        }

        // Contar productos publicados
        $count = count_user_posts( $user_id, 'micatalogo_product', true );

        // Si es una actualización de un post existente, no sumar al conteo
        if ( isset( $postarr['ID'] ) && $postarr['ID'] > 0 ) {
            $existing_post = get_post( $postarr['ID'] );
            if ( $existing_post && $existing_post->post_status === 'publish' ) {
                return $data; // Ya estaba publicado, no consume nuevo cupo
            }
        }

        if ( $count >= $limit ) {
            // Revertir a borrador e inyectar un error (aunque no es perfecto sin UI de Gutenberg, previene la publicación)
            $data['post_status'] = 'draft';
        }

        return $data;
    }

    public function check_image_limits( $file ) {
        $user_id = get_current_user_id();
        if ( ! $user_id || ! in_array( 'vendor', (array) get_userdata( $user_id )->roles ) ) {
            return $file;
        }

        // Esto requeriría saber a qué post se está subiendo para contar los attachments de ese post.
        // Dado que wp_handle_upload_prefilter se ejecuta globalmente, una validación estricta por producto
        // requiere comprobar el $_REQUEST['post_id'].
        if ( isset( $_REQUEST['post_id'] ) ) {
            $post_id = intval( $_REQUEST['post_id'] );
            $post = get_post( $post_id );
            if ( $post && $post->post_type === 'micatalogo_product' ) {
                $plan_id = get_user_meta( $user_id, 'micatalogo_plan', true ) ?: 'basic';
                $billing = new SaaS_Billing();
                $plans = $billing->get_plans();
                $img_limit = isset($plans[$plan_id]['images_limit']) ? $plans[$plan_id]['images_limit'] : 1;

                if ( $img_limit !== -1 ) {
                    // Contar imágenes adjuntas a este producto
                    $attachments = get_children( [
                        'post_parent' => $post_id,
                        'post_type'   => 'attachment',
                        'post_mime_type' => 'image',
                        'numberposts' => -1,
                    ] );
                    
                    if ( count( $attachments ) >= $img_limit ) {
                        $file['error'] = 'Has superado el límite de imágenes para este producto según tu plan.';
                    }
                }
            }
        }

        return $file;
    }
}
