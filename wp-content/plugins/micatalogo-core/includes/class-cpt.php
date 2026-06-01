<?php
namespace MiCatalogo;

class CPT {
    public function __construct() {
        add_action( 'init', [ $this, 'register_cpts' ] );
    }

    public function register_cpts() {
        // Producto
        register_post_type( 'producto', [
            'labels' => [
                'name' => __( 'Productos', 'micatalogo-saas' ),
                'singular_name' => __( 'Producto', 'micatalogo-saas' ),
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
            'capability_type' => 'producto',
            'map_meta_cap' => true,
        ]);

        // Pedido
        register_post_type( 'pedido', [
            'labels' => [
                'name' => __( 'Pedidos', 'micatalogo-saas' ),
                'singular_name' => __( 'Pedido', 'micatalogo-saas' ),
            ],
            'public' => false,
            'show_ui' => true,
            'supports' => [ 'title', 'custom-fields' ],
            'capability_type' => 'pedido',
            'map_meta_cap' => true,
        ]);

        // Reseña
        register_post_type( 'resena', [
            'labels' => [
                'name' => __( 'Reseñas', 'micatalogo-saas' ),
                'singular_name' => __( 'Reseña', 'micatalogo-saas' ),
            ],
            'public' => false,
            'show_ui' => true,
        ]);

        // KYC Document
        register_post_type( 'kyc_document', [
            'labels' => [
                'name' => __( 'Documentos KYC', 'micatalogo-saas' ),
                'singular_name' => __( 'Documento KYC', 'micatalogo-saas' ),
            ],
            'public' => false,
            'show_ui' => true,
            'capabilities' => [
                'create_posts' => 'do_not_allow',
            ],
            'map_meta_cap' => true,
        ]);
    }
}
