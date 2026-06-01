<?php
namespace MiCatalogo;

class Stats {
    public function __construct() {
        add_action( 'wp_head', [ $this, 'track_product_view' ] );
        add_action( 'wp_ajax_micatalogo_track_whatsapp_click', [ $this, 'track_whatsapp_click' ] );
        add_action( 'wp_ajax_nopriv_micatalogo_track_whatsapp_click', [ $this, 'track_whatsapp_click' ] );
    }

    public function track_product_view() {
        if ( is_singular( 'producto' ) ) {
            $post_id = get_the_ID();
            $views = (int) get_post_meta( $post_id, '_views', true );
            update_post_meta( $post_id, '_views', $views + 1 );
        }
    }

    public function track_whatsapp_click() {
        $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;
        if ( $product_id ) {
            $clicks = (int) get_post_meta( $product_id, '_whatsapp_clicks', true );
            update_post_meta( $product_id, '_whatsapp_clicks', $clicks + 1 );
            wp_send_json_success();
        }
        wp_send_json_error();
    }
}
