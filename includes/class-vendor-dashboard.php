<?php
namespace MiCatalogo;

class Vendor_Dashboard {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_dashboard_assets' ] );
        add_action( 'init', [ $this, 'process_product_actions' ] );
    }

    public function enqueue_dashboard_assets() {
        if ( is_page_template( 'page-templates/page-panel.php' ) ) {
            wp_enqueue_media(); // Permite subir imágenes
        }
    }

    public function get_stats( $user_id ) {
        $products_count = count_user_posts( $user_id, 'producto' );
        
        // Obtener pedidos del mes reales
        $orders_query = new \WP_Query([
            'post_type'      => 'pedido',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => [
                [
                    'key'   => '_vendor_id',
                    'value' => $user_id,
                ]
            ],
            'date_query'     => [
                [
                    'year'  => date('Y'),
                    'month' => date('m'),
                ],
            ],
        ]);
        
        return [
            'views_today' => rand(20, 150), // Todo: Implementar visitas reales a futuro
            'orders_month' => $orders_query->found_posts,
            'products_active' => $products_count
        ];
    }

    public function get_vendor_products( $user_id ) {
        return get_posts([
            'post_type' => 'producto',
            'author' => $user_id,
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ]);
    }

    public function process_product_actions() {
        if ( $_SERVER['REQUEST_METHOD'] !== 'POST' || ! isset( $_POST['micatalogo_product_action'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['micatalogo_product_nonce'], 'micatalogo_save_product' ) ) {
            wp_die( 'Acceso denegado.' );
        }

        $user_id = get_current_user_id();
        $action = $_POST['micatalogo_product_action'];

        if ( $action === 'create' ) {
            $title = sanitize_text_field( $_POST['product_title'] );
            $price = floatval( $_POST['product_price'] );
            $desc = sanitize_textarea_field( $_POST['product_desc'] );
            
            $post_id = wp_insert_post([
                'post_title' => $title,
                'post_content' => $desc,
                'post_type' => 'producto',
                'post_status' => 'publish',
                'post_author' => $user_id
            ]);

            if ( ! is_wp_error( $post_id ) ) {
                update_post_meta( $post_id, '_price', $price );
                
                if ( ! empty( $_FILES['product_image']['name'] ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                    require_once( ABSPATH . 'wp-admin/includes/media.php' );
                    
                    $attachment_id = media_handle_upload( 'product_image', $post_id );
                    if ( ! is_wp_error( $attachment_id ) ) {
                        set_post_thumbnail( $post_id, $attachment_id );
                    }
                }
            }
            wp_redirect( site_url('/panel-vendedor/#productos') );
            exit;
        }

        if ( $action === 'edit' ) {
            $post_id = intval( $_POST['product_id'] );
            $post = get_post( $post_id );
            
            if ( $post && intval($post->post_author) === $user_id ) {
                $title = sanitize_text_field( $_POST['product_title'] );
                $price = floatval( $_POST['product_price'] );
                $desc = sanitize_textarea_field( $_POST['product_desc'] );
                
                wp_update_post([
                    'ID'           => $post_id,
                    'post_title'   => $title,
                    'post_content' => $desc,
                ]);

                update_post_meta( $post_id, '_price', $price );
                
                if ( ! empty( $_FILES['product_image']['name'] ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                    require_once( ABSPATH . 'wp-admin/includes/media.php' );
                    
                    $attachment_id = media_handle_upload( 'product_image', $post_id );
                    if ( ! is_wp_error( $attachment_id ) ) {
                        set_post_thumbnail( $post_id, $attachment_id );
                    }
                }
            }
            wp_redirect( site_url('/panel-vendedor/#productos') );
            exit;
        }

        if ( $action === 'delete' ) {
            $post_id = intval( $_POST['product_id'] );
            $post = get_post( $post_id );
            if ( $post && intval($post->post_author) === $user_id ) {
                wp_delete_post( $post_id, true );
            }
            wp_redirect( site_url('/panel-vendedor/#productos') );
            exit;
        }

        if ( $action === 'update_settings' ) {
            if ( isset( $_POST['exchange_rate'] ) ) {
                $rate = floatval( $_POST['exchange_rate'] );
                if ( $rate > 0 ) {
                    update_user_meta( $user_id, 'exchange_rate', $rate );
                }
            }
            if ( isset( $_POST['whatsapp_number'] ) ) {
                $wa = sanitize_text_field( $_POST['whatsapp_number'] );
                update_user_meta( $user_id, 'whatsapp_number', $wa );
            }
            wp_redirect( site_url('/panel-vendedor/#configuracion') );
            exit;
        }
    }
}
