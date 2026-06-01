<?php
/**
 * Plugin Name: MiCatalogo Core
 * Plugin URI: https://github.com/merchandev/micatalogo
 * Description: Core logic and functionalities for the MiCatalogo SaaS platform. This plugin is required for the MiCatalogo theme to work properly.
 * Version: 1.0.0
 * Author: Arturo
 * Text Domain: micatalogo-core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'MICATALOGO_CORE_VERSION', '1.0.0' );
define( 'MICATALOGO_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'MICATALOGO_CORE_URL', plugin_dir_url( __FILE__ ) );

// Setup a simple autoloader / manual requires
require_once MICATALOGO_CORE_PATH . 'includes/class-db-setup.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-core.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-cpt.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-setup.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-performance-security.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-auth.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-register.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-onboarding.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-vendor-dashboard.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-customer-dashboard.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-cart.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-whatsapp-order.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-kyc.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-encryption.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-multisite.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-saas-billing.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-limits.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-reviews.php';

// FASE 2
require_once MICATALOGO_CORE_PATH . 'includes/class-variations.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-csv-handler.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-stats.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-wishlist.php';
require_once MICATALOGO_CORE_PATH . 'includes/class-super-admin-dashboard.php';

// Activar base de datos en la activación del plugin
register_activation_hook( __FILE__, function() {
    \MiCatalogo\DB_Setup::create_tables();
    \MiCatalogo\DB_Setup::migrate_old_products();
} );

// Inicializar el núcleo cuando carguen los plugins
add_action( 'plugins_loaded', 'micatalogo_core_init' );
function micatalogo_core_init() {
    new \MiCatalogo\Core();
    new \MiCatalogo\CPT();
    new \MiCatalogo\Setup();
    new \MiCatalogo\PerformanceSecurity();
    new \MiCatalogo\Auth();
    new \MiCatalogo\Onboarding();
    new \MiCatalogo\Vendor_Dashboard();

    if ( is_multisite() ) {
        // Multisite setup check could go here if needed.
    }
}
