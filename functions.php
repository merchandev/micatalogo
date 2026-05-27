<?php
/**
 * Funciones del tema MiCatálogo SaaS
 *
 * @package MiCatalogo
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'MICATALOGO_THEME_VERSION', '1.0.3' );
define( 'MICATALOGO_DIR', get_template_directory() );
define( 'MICATALOGO_URI', get_template_directory_uri() );

// Autocargador simple para clases
require_once MICATALOGO_DIR . '/includes/class-core.php';
require_once MICATALOGO_DIR . '/includes/class-cpt.php';
require_once MICATALOGO_DIR . '/includes/class-setup.php';
require_once MICATALOGO_DIR . '/includes/class-performance-security.php';
require_once MICATALOGO_DIR . '/includes/class-auth.php'; // Nueva clase de autenticación
require_once MICATALOGO_DIR . '/includes/class-register.php';
require_once MICATALOGO_DIR . '/includes/class-onboarding.php';
require_once MICATALOGO_DIR . '/includes/class-vendor-dashboard.php';
require_once MICATALOGO_DIR . '/includes/class-customer-dashboard.php';
require_once MICATALOGO_DIR . '/includes/class-cart.php';
require_once MICATALOGO_DIR . '/includes/class-whatsapp-order.php';
require_once MICATALOGO_DIR . '/includes/class-kyc.php';
require_once MICATALOGO_DIR . '/includes/class-encryption.php';
require_once MICATALOGO_DIR . '/includes/class-multisite.php';
require_once MICATALOGO_DIR . '/includes/class-saas-billing.php';
require_once MICATALOGO_DIR . '/includes/class-limits.php';
require_once MICATALOGO_DIR . '/includes/class-reviews.php';

// FASE 2
require_once MICATALOGO_DIR . '/includes/class-variations.php';
require_once MICATALOGO_DIR . '/includes/class-csv-handler.php';
require_once MICATALOGO_DIR . '/includes/class-stats.php';
require_once MICATALOGO_DIR . '/includes/class-wishlist.php';
require_once MICATALOGO_DIR . '/includes/class-super-admin-dashboard.php';

// Cambiar base de autor a /tienda/
add_action( 'init', function() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'tienda';
    $wp_rewrite->author_structure = '/' . $wp_rewrite->author_base . '/%author%';
} );

// Instanciar núcleo
new \MiCatalogo\Core();
new \MiCatalogo\CPT();
new \MiCatalogo\Setup();
new \MiCatalogo\PerformanceSecurity();
new \MiCatalogo\Auth(); // Instanciamos la clase Auth
new \MiCatalogo\Onboarding(); // Asistente inicial
new \MiCatalogo\Vendor_Dashboard(); // Panel de control

if ( is_multisite() ) {
    require_once MICATALOGO_DIR . '/includes/class-multisite.php';
}

// Configuración básica del tema
add_action( 'after_setup_theme', function() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
    
    // Registrar menús
    register_nav_menus( [
        'menu-principal' => __( 'Menú Principal', 'micatalogo-saas' ),
        'menu-footer'    => __( 'Menú del Footer', 'micatalogo-saas' ),
    ] );
});

// Inicialización de módulos se hace globalmente arriba para evitar duplicidades


// Roles y capacidades
add_action( 'after_switch_theme', function() {
    // Aquí se podrían crear páginas por defecto.
    
    // Añadir roles o actualizar capacidades
    $vendor_role = get_role( 'vendor' );
    if ( ! $vendor_role ) {
        $vendor_role = add_role( 'vendor', __( 'Vendedor', 'micatalogo-saas' ), array(
            'read'         => true,
            'upload_files' => true,
        ) );
    }
    if ( $vendor_role ) {
        $vendor_role->add_cap( 'edit_producto' );
        $vendor_role->add_cap( 'edit_productos' );
        $vendor_role->add_cap( 'publish_productos' );
        $vendor_role->add_cap( 'delete_producto' );
        $vendor_role->add_cap( 'delete_productos' );
        $vendor_role->add_cap( 'upload_files' );
        $vendor_role->add_cap( 'edit_pedido' );
        $vendor_role->add_cap( 'read_pedido' );
        $vendor_role->add_cap( 'delete_pedido' );
        $vendor_role->add_cap( 'edit_pedidos' );
        $vendor_role->add_cap( 'publish_pedidos' );
        $vendor_role->add_cap( 'read_private_pedidos' );
        $vendor_role->add_cap( 'read_private_productos' );
    }
    
    if ( ! get_role( 'customer' ) ) {
        add_role( 'customer', __( 'Cliente', 'micatalogo-saas' ), array(
            'read' => true,
        ) );
    }
});

// Cargar scripts y estilos
add_action( 'wp_enqueue_scripts', function() {
    // Google Fonts (Material Symbols Outlined + Google Fonts)
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null );
    wp_enqueue_style( 'material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0', array(), null );

    wp_enqueue_style( 'micatalogo-theme', get_template_directory_uri() . '/assets/css/theme.css', array('google-fonts', 'material-symbols'), wp_get_theme()->get('Version') );
    
    // Scripts
    wp_enqueue_script( 'micatalogo-animations', MICATALOGO_URI . '/assets/js/animations.js', array(), MICATALOGO_THEME_VERSION, true );
    
    // Scripts de carrito y checkout
    wp_enqueue_script( 'micatalogo-cart', MICATALOGO_URI . '/assets/js/cart.js', array( 'jquery' ), MICATALOGO_THEME_VERSION, true );
    wp_enqueue_script( 'micatalogo-checkout', MICATALOGO_URI . '/assets/js/checkout.js', array( 'jquery' ), MICATALOGO_THEME_VERSION, true );
    
    // Pasar variables a JS
    wp_localize_script( 'micatalogo-cart', 'micatalogo_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'micatalogo_cart_nonce' )
    ) );
});
