<?php
namespace MiCatalogo;

class Variations {
    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'add_variations_metabox' ] );
        add_action( 'save_post_producto', [ $this, 'save_variations_meta' ] );
    }

    public function add_variations_metabox() {
        // Mostrar metabox solo si el plan lo permite (ej: Pro o Enterprise)
        add_meta_box(
            'micatalogo_variations_mb',
            __( 'Variantes de Producto', 'micatalogo-saas' ),
            [ $this, 'render_variations_metabox' ],
            'producto',
            'normal',
            'high'
        );
    }

    public function render_variations_metabox( $post ) {
        wp_nonce_field( 'micatalogo_variations_nonce', 'micatalogo_variations_nonce_field' );
        $variations_json = get_post_meta( $post->ID, '_product_variations', true );
        ?>
        <div id="micatalogo-variations-app">
            <textarea name="micatalogo_variations_data" style="width:100%; height:150px;"><?php echo esc_textarea( $variations_json ); ?></textarea>
            <p class="description">Introduce un JSON válido. Ejemplo: <code>[{"name": "Talla M", "price": "25", "stock": 10}]</code></p>
        </div>
        <?php
    }

    public function save_variations_meta( $post_id ) {
        if ( ! isset( $_POST['micatalogo_variations_nonce_field'] ) || ! wp_verify_nonce( $_POST['micatalogo_variations_nonce_field'], 'micatalogo_variations_nonce' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['micatalogo_variations_data'] ) ) {
            $data = sanitize_text_field( wp_unslash( $_POST['micatalogo_variations_data'] ) );
            update_post_meta( $post_id, '_product_variations', $data );
        }
    }
}
