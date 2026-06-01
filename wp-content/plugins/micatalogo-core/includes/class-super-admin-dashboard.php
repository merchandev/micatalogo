<?php
namespace MiCatalogo;

class SuperAdminDashboard {
    public function __construct() {
        add_action( 'network_admin_menu', [ $this, 'add_network_menu' ] );
    }

    public function add_network_menu() {
        add_menu_page(
            __( 'SaaS Dashboard', 'micatalogo-saas' ),
            __( 'SaaS Dashboard', 'micatalogo-saas' ),
            'manage_network',
            'micatalogo-saas-dashboard',
            [ $this, 'render_dashboard' ],
            'dashicons-chart-pie',
            3
        );
    }

    public function render_dashboard() {
        echo '<div class="wrap"><h1>' . __( 'SaaS Super Admin Dashboard', 'micatalogo-saas' ) . '</h1>';
        echo '<p>Métricas globales de red, MRR, Churn y gestión de sitios.</p>';
        echo '</div>';
    }
}
