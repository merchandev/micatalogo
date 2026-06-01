<?php
/**
 * Escaparate Público del Vendedor (Catálogo)
 */
get_header();

$vendor_id = get_query_var( 'author' );
$vendor = get_userdata( $vendor_id );
$store_name = get_user_meta( $vendor_id, 'store_name', true ) ?: $vendor->display_name;
$store_desc = get_user_meta( $vendor_id, 'store_description', true );
$whatsapp = get_user_meta( $vendor_id, 'whatsapp_number', true );

$logo_id = get_user_meta( $vendor_id, 'store_logo', true );
$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'thumbnail' ) : '';

$exchange_rate = get_user_meta( $vendor_id, 'exchange_rate', true ) ?: 36.5;

// Consulta de productos del vendedor desde la tabla personalizada (Caché implementado)
global $wpdb;
$table_name = $wpdb->prefix . 'mc_productos';
$transient_key = 'mc_vendor_products_' . $vendor_id;
$vendor_products = get_transient( $transient_key );

if ( false === $vendor_products ) {
    $vendor_products = $wpdb->get_results( $wpdb->prepare( 
        "SELECT * FROM $table_name WHERE vendor_id = %d AND status = 'publish' ORDER BY created_at DESC", 
        $vendor_id 
    ) );
    set_transient( $transient_key, $vendor_products, 12 * HOUR_IN_SECONDS );
}

// Paginación básica (Simulada para mantener la estructura, se puede mejorar con ajax)
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$per_page = 12;
$total_products = count($vendor_products);
$offset = ($paged - 1) * $per_page;
$products_page = array_slice($vendor_products, $offset, $per_page);

// Guardar los datos del vendedor para el JS del carrito
echo '<script>
    window.MiCatalogoVendor = {
        id: "' . esc_js($vendor_id) . '",
        whatsapp: "' . esc_js($whatsapp) . '",
        storeName: "' . esc_js($store_name) . '"
    };
</script>';

// Si se está viendo un producto específico
if ( isset($_GET['item']) ) {
    $product_id = intval($_GET['item']);
    $product = null;
    foreach ($vendor_products as $p) {
        if ( (int)$p->id === $product_id ) {
            $product = $p;
            break;
        }
    }
    
    if ( $product ) {
        require get_stylesheet_directory() . "/single-producto.php";
        exit;
    }
}

// Determinar qué plantilla cargar
$template_choice = get_user_meta( $vendor_id, 'store_template', true );
if ( ! $template_choice || ! in_array( $template_choice, ['moderna', 'elegante', 'minimalista'] ) ) {
    $template_choice = 'moderna';
}

$template_file = get_stylesheet_directory() . "/templates/store-{$template_choice}.php";

// Cargar la plantilla estructural seleccionada
if ( file_exists( $template_file ) ) {
    require $template_file;
} else {
    // Fallback de seguridad si no existe el archivo
    require get_stylesheet_directory() . "/templates/store-moderna.php";
}
// Ya no necesitamos wp_reset_postdata()
?>

<!-- Carrito Flotante (Compartido para todas las plantillas) -->
<div id="floating-cart" class="floating-cart glass-card" style="display:none; position:fixed; bottom:20px; right:20px; z-index:900; padding:16px 24px; border-radius:30px; cursor:pointer; align-items:center; gap:16px;">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width:24px; height:24px;"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
    <span id="cart-count" style="font-weight:700;">0</span> artículos
    <span id="cart-total" style="color:var(--primary); font-weight:700;">$0.00</span>
</div>

<!-- Modal del Carrito -->
<div id="cart-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:1000; justify-content:flex-end; backdrop-filter:blur(4px);">
    <div class="cart-sidebar glass-card" style="width:100%; max-width:400px; height:100vh; background:var(--bg-dark); padding:32px; display:flex; flex-direction:column;">
        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border); padding-bottom:16px; margin-bottom:24px;">
            <h2 style="margin:0;">Tu Pedido</h2>
            <button onclick="document.getElementById('cart-modal').style.display='none'" style="background:none; border:none; color:#fff; font-size:1.5rem; cursor:pointer;">&times;</button>
        </div>
        
        <div id="cart-items-container" style="flex:1; overflow-y:auto; display:flex; flex-direction:column; gap:16px;">
            <!-- Renderizado por JS -->
        </div>

        <div style="border-top:1px solid var(--border); padding-top:24px; margin-top:24px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:16px; font-size:1.2rem; font-weight:700;">
                <span>Total:</span>
                <span id="cart-modal-total" style="color:var(--primary);">$0.00</span>
            </div>
            <button id="checkout-btn" class="button button-primary button-block" style="background:#25D366; border-color:#25D366; color:#000;">Enviar por WhatsApp</button>
        </div>
    </div>
</div>

<?php get_footer(); ?>
