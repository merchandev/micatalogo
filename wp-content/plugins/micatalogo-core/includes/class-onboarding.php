<?php
namespace MiCatalogo;

class Onboarding {
    public function __construct() {
        // Redirigir si no ha completado el onboarding
        add_action( 'template_redirect', [ $this, 'enforce_onboarding' ] );
        // Procesar formulario de onboarding
        add_action( 'init', [ $this, 'process_onboarding_form' ] );
    }

    public function enforce_onboarding() {
        if ( ! is_user_logged_in() ) {
            return;
        }

        $user_id = get_current_user_id();
        $is_onboarding_complete = get_user_meta( $user_id, 'onboarding_complete', true );
        
        // Evitar bucles infinitos detectando en qué página estamos
        global $wp;
        $current_url = home_url( add_query_arg( array(), $wp->request ) );
        $onboarding_url = site_url( '/onboarding/' );
        $panel_url = site_url( '/panel-vendedor/' );

        // Si no está completo y está en el panel, forzar a ir a onboarding
        if ( ! $is_onboarding_complete && strpos( $current_url, 'panel-vendedor' ) !== false ) {
            wp_redirect( $onboarding_url );
            exit;
        }

        // Si ya está completo y trata de ir al onboarding, enviarlo al panel
        if ( $is_onboarding_complete && strpos( $current_url, 'onboarding' ) !== false ) {
            wp_redirect( $panel_url );
            exit;
        }
    }

    public function process_onboarding_form() {
        if ( $_SERVER['REQUEST_METHOD'] !== 'POST' || ! isset( $_POST['micatalogo_onboarding_nonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['micatalogo_onboarding_nonce'], 'micatalogo_onboarding_action' ) ) {
            wp_die( 'Petición inválida.' );
        }

        $user_id = get_current_user_id();
        if ( ! $user_id ) return;

        $whatsapp = sanitize_text_field( $_POST['whatsapp'] );
        $description = isset($_POST['description']) ? sanitize_textarea_field( $_POST['description'] ) : '';

        // Procesar la subida del logo si existe
        if ( ! empty( $_FILES['store_logo']['name'] ) ) {
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );
            
            $attachment_id = media_handle_upload( 'store_logo', 0 );
            if ( ! is_wp_error( $attachment_id ) ) {
                update_user_meta( $user_id, 'store_logo', $attachment_id );
            }
        }

        // Guardar diseño (planilla)
        if ( isset($_POST['store_template']) ) {
            $store_template = sanitize_text_field( $_POST['store_template'] );
            update_user_meta( $user_id, 'store_template', $store_template );
        }

        // Procesar el primer producto
        if ( ! empty( $_POST['first_product_name'] ) && ! empty( $_POST['first_product_price'] ) ) {
            $product_name = sanitize_text_field( $_POST['first_product_name'] );
            $product_price = floatval( $_POST['first_product_price'] );
            
            $post_id = wp_insert_post( [
                'post_title'   => $product_name,
                'post_type'    => 'producto',
                'post_status'  => 'publish',
                'post_author'  => $user_id,
            ] );

            if ( ! is_wp_error( $post_id ) ) {
                update_post_meta( $post_id, '_price', $product_price );
                
                // Procesar la imagen del primer producto
                if ( ! empty( $_FILES['first_product_image']['name'] ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                    require_once( ABSPATH . 'wp-admin/includes/media.php' );
                    
                    $product_attachment_id = media_handle_upload( 'first_product_image', $post_id );
                    if ( ! is_wp_error( $product_attachment_id ) ) {
                        set_post_thumbnail( $post_id, $product_attachment_id );
                    }
                }
            }
        }

        update_user_meta( $user_id, 'whatsapp_number', $whatsapp );
        if ( $description ) update_user_meta( $user_id, 'store_description', $description );
        
        // Marcar como completo
        update_user_meta( $user_id, 'onboarding_complete', true );

        // Redirigir al dashboard
        wp_redirect( site_url( '/panel-vendedor/' ) );
        exit;
    }
}
