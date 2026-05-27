<?php
namespace MiCatalogo;

class Cart {
    public function __construct() {
        add_action( 'wp_ajax_micatalogo_add_to_cart', [ $this, 'ajax_add_to_cart' ] );
        add_action( 'wp_ajax_nopriv_micatalogo_add_to_cart', [ $this, 'ajax_add_to_cart' ] );
    }

    public function ajax_add_to_cart() {
        check_ajax_referer( 'micatalogo_cart_nonce', 'nonce' );

        $product_id = intval( $_POST['product_id'] ?? 0 );
        $qty = intval( $_POST['qty'] ?? 1 );
        
        if ( ! $product_id ) {
            wp_send_json_error( [ 'message' => 'Producto no válido' ] );
        }

        $cart = $this->get_cart();
        
        if ( isset( $cart[ $product_id ] ) ) {
            $cart[ $product_id ] += $qty;
        } else {
            $cart[ $product_id ] = $qty;
        }
        
        $this->save_cart( $cart );
        
        wp_send_json_success( [ 
            'message' => 'Añadido al carrito',
            'cart_count' => array_sum( $cart )
        ] );
    }

    public function get_cart() {
        if ( isset( $_COOKIE['micatalogo_cart'] ) ) {
            $cart = json_decode( stripslashes( $_COOKIE['micatalogo_cart'] ), true );
            return is_array( $cart ) ? $cart : [];
        }
        return [];
    }
    
    private function save_cart( $cart ) {
        $domain = parse_url( site_url(), PHP_URL_HOST );
        // Expira en 7 días, path global, httpOnly para evitar XSS
        setcookie( 'micatalogo_cart', wp_json_encode( $cart ), time() + (86400 * 7), '/', $domain, is_ssl(), true );
    }

    public function clear_cart() {
        $domain = parse_url( site_url(), PHP_URL_HOST );
        setcookie( 'micatalogo_cart', '', time() - 3600, '/', $domain, is_ssl(), true );
    }
}
