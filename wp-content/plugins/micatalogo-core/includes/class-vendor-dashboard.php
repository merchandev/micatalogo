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
        global $wpdb;
        $table_name = $wpdb->prefix . 'mc_productos';
        $products_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $table_name WHERE vendor_id = %d AND status = 'publish'", $user_id ) );
        
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
        
        // Calcular vistas (para simplificar por ahora, en una BD relacional podríamos crear tabla mc_stats o usar postmeta en pedidos)
        // Ya no tenemos _views en metadata, así que inicializamos en 0 hasta migrar analíticas a tabla propia
        $total_views = 0;
        
        return [
            'views_today' => $total_views,
            'orders_month' => $orders_query->found_posts,
            'products_active' => $products_count
        ];
    }

    public function get_vendor_products( $user_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mc_productos';
        
        // Intentar obtener de la caché (Transient API)
        $transient_key = 'mc_vendor_products_' . $user_id;
        $cached_products = get_transient( $transient_key );
        
        if ( false === $cached_products ) {
            $cached_products = $wpdb->get_results( $wpdb->prepare( 
                "SELECT * FROM $table_name WHERE vendor_id = %d ORDER BY created_at DESC", 
                $user_id 
            ) );
            
            // Guardar en caché por 12 horas
            set_transient( $transient_key, $cached_products, 12 * HOUR_IN_SECONDS );
        }
        
        return $cached_products;
    }
    
    public function clear_vendor_cache( $user_id ) {
        delete_transient( 'mc_vendor_products_' . $user_id );
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
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'mc_productos';

        if ( $action === 'create' ) {
            $title = sanitize_text_field( $_POST['product_title'] );
            $price = floatval( $_POST['product_price'] );
            $desc = sanitize_textarea_field( $_POST['product_desc'] );
            $image_id = 0;
            
            if ( ! empty( $_FILES['product_image']['name'] ) ) {
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
                require_once( ABSPATH . 'wp-admin/includes/media.php' );
                
                $attachment_id = media_handle_upload( 'product_image', 0 );
                if ( ! is_wp_error( $attachment_id ) ) {
                    $image_id = $attachment_id;
                }
            }
            
            $wpdb->insert(
                $table_name,
                [
                    'vendor_id'   => $user_id,
                    'title'       => $title,
                    'description' => $desc,
                    'price'       => $price,
                    'image_id'    => $image_id,
                    'status'      => 'publish',
                    'created_at'  => current_time('mysql')
                ]
            );
            
            $this->clear_vendor_cache( $user_id );

            wp_redirect( site_url('/panel-vendedor/#productos') );
            exit;
        }

        if ( $action === 'edit' ) {
            $product_id = intval( $_POST['product_id'] );
            
            // Verificar pertenencia
            $product = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d AND vendor_id = %d", $product_id, $user_id ) );
            
            if ( $product ) {
                $title = sanitize_text_field( $_POST['product_title'] );
                $price = floatval( $_POST['product_price'] );
                $desc = sanitize_textarea_field( $_POST['product_desc'] );
                $image_id = $product->image_id;
                
                if ( ! empty( $_FILES['product_image']['name'] ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                    require_once( ABSPATH . 'wp-admin/includes/media.php' );
                    
                    $attachment_id = media_handle_upload( 'product_image', 0 );
                    if ( ! is_wp_error( $attachment_id ) ) {
                        $image_id = $attachment_id;
                    }
                }
                
                $wpdb->update(
                    $table_name,
                    [
                        'title'       => $title,
                        'description' => $desc,
                        'price'       => $price,
                        'image_id'    => $image_id
                    ],
                    [ 'id' => $product_id, 'vendor_id' => $user_id ]
                );
                
                $this->clear_vendor_cache( $user_id );
            }
            wp_redirect( site_url('/panel-vendedor/#productos') );
            exit;
        }

        if ( $action === 'delete' ) {
            $product_id = intval( $_POST['product_id'] );
            
            $wpdb->delete(
                $table_name,
                [ 'id' => $product_id, 'vendor_id' => $user_id ]
            );
            
            $this->clear_vendor_cache( $user_id );

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
