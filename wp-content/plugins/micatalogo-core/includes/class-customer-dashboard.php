<?php
namespace MiCatalogo;

class CustomerDashboard {
    public function __construct() {
        add_shortcode( 'micatalogo_customer_account', [ $this, 'render_account' ] );
    }

    public function render_account() {
        if ( ! is_user_logged_in() ) {
            return __( 'Debes iniciar sesión para ver tus pedidos.', 'micatalogo-saas' );
        }
        
        $current_user = wp_get_current_user();
        
        // Buscar pedidos por autor o por email guardado en meta
        $args = [
            'post_type' => 'pedido',
            'posts_per_page' => -1,
            'meta_query' => [
                'relation' => 'OR',
                [
                    'key' => '_customer_email',
                    'value' => $current_user->user_email,
                    'compare' => '='
                ]
            ],
            // Podríamos incluir autor si el pedido se creó con sesión iniciada
        ];
        
        $pedidos = new \WP_Query( $args );
        
        $html = '<h2>' . __( 'Mis Pedidos', 'micatalogo-saas' ) . '</h2>';
        
        if ( $pedidos->have_posts() ) {
            $html .= '<ul class="micatalogo-order-list">';
            while ( $pedidos->have_posts() ) {
                $pedidos->the_post();
                $html .= '<li>';
                $html .= '<strong>Pedido #' . get_the_ID() . '</strong> - ' . get_the_date();
                $html .= ' <a href="#" class="button button-small repeat-order-btn" data-order-id="' . get_the_ID() . '">Repetir Pedido</a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
            wp_reset_postdata();
        } else {
            $html .= '<p>' . __( 'No has realizado ningún pedido aún.', 'micatalogo-saas' ) . '</p>';
        }
        
        return $html;
    }
}
