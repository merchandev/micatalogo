<?php
namespace MiCatalogo;

class PerformanceSecurity {
    public function __construct() {
        // Seguridad
        add_action( 'init', [ $this, 'cleanup_head' ] );
        add_action( 'send_headers', [ $this, 'add_security_headers' ] );
        
        // Rendimiento
        add_filter( 'script_loader_tag', [ $this, 'defer_scripts' ], 10, 3 );
    }

    public function cleanup_head() {
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
        remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
    }

    public function add_security_headers() {
        if ( ! is_admin() ) {
            header( 'X-Content-Type-Options: nosniff' );
            header( 'X-Frame-Options: SAMEORIGIN' );
            header( 'X-XSS-Protection: 1; mode=block' );
            header( 'Referrer-Policy: strict-origin-when-cross-origin' );
        }
    }

    public function defer_scripts( $tag, $handle, $src ) {
        // Lista de scripts para aplicar defer
        $defer_scripts = [ 'micatalogo-cart', 'micatalogo-checkout' ];
        
        if ( in_array( $handle, $defer_scripts, true ) ) {
            return str_replace( ' src', ' defer="defer" src', $tag );
        }
        
        return $tag;
    }
}
