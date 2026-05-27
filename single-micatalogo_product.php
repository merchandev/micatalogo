<?php
/**
 * Vista individual del producto
 */
get_header(); 

$price = get_post_meta( get_the_ID(), '_price', true );
$vendor_id = get_post_field( 'post_author', get_the_ID() );
$store_name = get_user_meta( $vendor_id, 'store_name', true );
$whatsapp = get_user_meta( $vendor_id, 'whatsapp_number', true );
$exchange_rate = get_user_meta( $vendor_id, 'exchange_rate', true ) ?: 36.5;
$price_bs = (float)$price * (float)$exchange_rate;

echo '<script>
    window.MiCatalogoVendor = {
        id: "' . esc_js($vendor_id) . '",
        whatsapp: "' . esc_js($whatsapp) . '",
        storeName: "' . esc_js($store_name) . '"
    };
</script>';

?>

<main class="single-product-page container" style="padding: 60px 0; min-height: 80vh;">
    <a href="<?php echo esc_url( get_author_posts_url( $vendor_id ) ); ?>" style="color:var(--text-muted); text-decoration:none; margin-bottom:32px; display:inline-block;">&larr; Volver a <?php echo esc_html($store_name); ?></a>

    <div class="single-product-layout" style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: start;">
        
        <div class="product-gallery glass-card" style="padding: 16px; border-radius: 16px;">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'large', ['style' => 'width:100%; height:auto; border-radius:8px; object-fit:cover;'] ); ?>
            <?php else : ?>
                <div style="width:100%; height:400px; background:var(--border); border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--text-muted);">Sin Imagen</div>
            <?php endif; ?>
        </div>

        <div class="product-details reveal-right">
            <h1 style="font-size: 2.5rem; margin-bottom: 16px;"><?php the_title(); ?></h1>
            <div class="price" style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 32px;">
                <span style="font-size: 2.5rem; color: var(--primary); font-weight: 800; line-height: 1;">$<?php echo number_format((float)$price, 2); ?></span>
                <span style="font-size: 1.2rem; color: var(--text-muted); font-weight: 500;">Bs. <?php echo number_format($price_bs, 2, ',', '.'); ?></span>
            </div>
            
            <div class="description" style="color: var(--text-muted); line-height: 1.8; margin-bottom: 40px; font-size: 1.1rem;">
                <?php the_content(); ?>
            </div>

            <button type="button" class="button button-primary button-block add-to-cart-btn" style="padding: 18px; font-size: 1.1rem;"
                data-id="<?php the_ID(); ?>" 
                data-title="<?php echo esc_attr(get_the_title()); ?>" 
                data-price="<?php echo esc_attr($price); ?>"
                data-pricebs="<?php echo esc_attr($price_bs); ?>">
                Añadir al Pedido
            </button>
        </div>
    </div>
</main>

<!-- El carrito flotante se hereda lógicamente de un footer o se renderiza vía JS, aquí lo simplificamos inyectando el mismo markup del author.php para mantenerlo aislado por ahora -->
<div id="floating-cart" class="floating-cart glass-card" style="display:none; position:fixed; bottom:20px; right:20px; z-index:900; padding:16px 24px; border-radius:30px; cursor:pointer; align-items:center; gap:16px;">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width:24px; height:24px;"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
    <span id="cart-count" style="font-weight:700;">0</span> artículos
    <span id="cart-total" style="color:var(--primary); font-weight:700;">$0.00</span>
</div>

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
