<?php
/**
 * Vista individual del producto
 */
get_header(); 

// $vendor_id, $store_name, $whatsapp, y $exchange_rate ya vienen de author.php
$price = $product->price;
$price_bs = (float)$price * (float)$exchange_rate;
$image_url = $product->image_id ? wp_get_attachment_image_url($product->image_id, 'large') : '';

// Datos para JS si queremos usar el carrito aquí también
echo '<script>
    window.MiCatalogoVendor = {
        id: "' . esc_js($vendor_id) . '",
        whatsapp: "' . esc_js($whatsapp) . '",
        storeName: "' . esc_js($store_name) . '"
    };
</script>';

// Preparar enlace de WhatsApp directo para este producto
$product_title = $product->title;
$product_url = get_author_posts_url($vendor_id) . '?item=' . $product->id;
$wa_message = urlencode("Hola {$store_name}, me interesa el producto '{$product_title}' que vi en su catálogo. ¿Me podrían dar más información?\n\nVer producto: {$product_url}");
$wa_link = "https://wa.me/{$whatsapp}?text={$wa_message}";
?>

<main class="single-product-page container" style="padding: 60px 0; min-height: 80vh;">
    <a href="<?php echo esc_url( get_author_posts_url( $vendor_id ) ); ?>" style="color:var(--text-muted); text-decoration:none; margin-bottom:32px; display:inline-block; font-weight:500;">
        &larr; Volver a <?php echo esc_html($store_name); ?>
    </a>

    <div class="single-product-layout" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 60px; align-items: start;">
        
        <div class="product-gallery glass-card reveal-up" style="padding: 24px; border-radius: var(--radius-lg); background: var(--bg-card);">
            <?php if ( $image_url ) : ?>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product_title); ?>" style="width:100%; height:auto; border-radius:12px; object-fit:cover; display:block;">
            <?php else : ?>
                <div style="width:100%; height:400px; background:var(--border); border-radius:12px; display:flex; align-items:center; justify-content:center; color:var(--text-muted); font-size:1.2rem;">Sin Imagen</div>
            <?php endif; ?>
        </div>

        <div class="product-details reveal-right">
            <h1 style="font-size: 3rem; margin-bottom: 16px; font-weight: 800; line-height: 1.2; color: var(--text-main);"><?php echo esc_html($product_title); ?></h1>
            
            <div class="price" style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid var(--border);">
                <span style="font-size: 2.5rem; color: var(--primary); font-weight: 800; line-height: 1;">$<?php echo number_format((float)$price, 2); ?></span>
                <span style="font-size: 1.25rem; color: var(--text-muted); font-weight: 500;">Bs. <?php echo number_format($price_bs, 2, ',', '.'); ?></span>
            </div>
            
            <div class="description" style="color: var(--text-main); opacity: 0.9; line-height: 1.8; margin-bottom: 40px; font-size: 1.15rem;">
                <?php echo wpautop( esc_html( $product->description ) ); ?>
            </div>

            <div class="product-actions" style="display: flex; flex-direction: column; gap: 16px;">
                <!-- Botón de Pedir Info por WhatsApp (Directo) -->
                <a href="<?php echo esc_url($wa_link); ?>" target="_blank" class="button button-block" style="background: #25D366; color: #FFF; font-size: 1.1rem; font-weight: 600; padding: 18px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 4px 20px rgba(37, 211, 102, 0.3);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    Pedir información por WhatsApp
                </a>

                <!-- Botón Añadir al Pedido (Carrito Múltiple) -->
                <button type="button" class="button button-outline button-block add-to-cart-btn" style="padding: 18px; font-size: 1.1rem; border-radius: 12px;"
                    data-id="<?php echo esc_attr($product->id); ?>" 
                    data-title="<?php echo esc_attr($product_title); ?>" 
                    data-price="<?php echo esc_attr($price); ?>"
                    data-pricebs="<?php echo esc_attr($price_bs); ?>">
                    Agregar al pedido (Múltiples productos)
                </button>
            </div>
            
            <!-- Trust Indicators -->
            <div style="margin-top: 32px; padding-top: 32px; border-top: 1px solid var(--border); display: flex; gap: 24px; color: var(--text-muted); font-size: 0.95rem;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width: 20px; height: 20px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    Compra Segura
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width: 20px; height: 20px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Venta Directa
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Carrito flotante -->
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
        <div id="cart-items-container" style="flex:1; overflow-y:auto; display:flex; flex-direction:column; gap:16px;"></div>
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
