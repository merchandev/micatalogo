<?php
namespace MiCatalogo;

class Wishlist {
    public function __construct() {
        add_shortcode( 'micatalogo_wishlist', [ $this, 'render_wishlist' ] );
        add_action( 'wp_ajax_micatalogo_add_wishlist', [ $this, 'ajax_add_wishlist' ] );
    }

    public function render_wishlist() {
        if ( ! is_user_logged_in() ) {
            return __( 'Debes iniciar sesión para ver tus favoritos.', 'micatalogo-saas' );
        }
        
        $user_id = get_current_user_id();
        $wishlist = get_user_meta( $user_id, '_micatalogo_wishlist', true ) ?: [];
        
        if ( empty( $wishlist ) ) {
            return '<p>' . __( 'Tu lista de deseos está vacía.', 'micatalogo-saas' ) . '</p>';
        }
        
        $html = '<ul class="wishlist">';
        foreach ( $wishlist as $product_id ) {
            $html .= '<li>' . get_the_title( $product_id ) . '</li>';
        }
        $html .= '</ul>';
        
        return $html;
    }

    public function ajax_add_wishlist() {
        if ( ! is_user_logged_in() ) {
            wp_send_json_error( 'Debes iniciar sesión' );
        }
        $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;
        $user_id = get_current_user_id();
        
        $wishlist = get_user_meta( $user_id, '_micatalogo_wishlist', true ) ?: [];
        if ( ! in_array( $product_id, $wishlist ) ) {
            $wishlist[] = $product_id;
            update_user_meta( $user_id, '_micatalogo_wishlist', $wishlist );
        }
        
        wp_send_json_success();
    }
}
