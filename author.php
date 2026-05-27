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

// Consulta de productos del vendedor
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = [
    'post_type'      => 'micatalogo_product',
    'author'         => $vendor_id,
    'posts_per_page' => 12,
    'paged'          => $paged
];
$products_query = new WP_Query( $args );

// Guardar los datos del vendedor para el JS del carrito
echo '<script>
    window.MiCatalogoVendor = {
        id: "' . esc_js($vendor_id) . '",
        whatsapp: "' . esc_js($whatsapp) . '",
        storeName: "' . esc_js($store_name) . '"
    };
</script>';

?>

<main class="storefront">
    
    <!-- Header de la Tienda -->
    <header class="storefront-header text-center reveal-fade">
        <div class="container">
            <?php if ( $logo_url ) : ?>
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $store_name ); ?>" class="store-logo">
            <?php else : ?>
                <div class="store-logo-placeholder"><?php echo substr($store_name, 0, 1); ?></div>
            <?php endif; ?>
            
            <h1 class="store-name"><?php echo esc_html( $store_name ); ?></h1>
            <?php if ( $store_desc ) : ?>
                <p class="store-desc"><?php echo esc_html( $store_desc ); ?></p>
            <?php endif; ?>
        </div>
    </header>

    <!-- Grid de Productos -->
    <section class="store-catalog container" style="padding: 60px 0;">
        <?php if ( $products_query->have_posts() ) : ?>
            <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 32px;">
                <?php 
                $exchange_rate = get_user_meta( $vendor_id, 'exchange_rate', true ) ?: 36.5;

                while ( $products_query->have_posts() ) : $products_query->the_post(); 
                    $price = get_post_meta( get_the_ID(), '_price', true );
                    $price_bs = (float)$price * (float)$exchange_rate;
                ?>
                    <article class="product-card glass-card reveal-up">
                        <a href="<?php the_permalink(); ?>" class="product-link">
                            <div class="product-image">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium', ['style' => 'width:100%; height:250px; object-fit:cover; border-radius:12px 12px 0 0;'] ); ?>
                                <?php else : ?>
                                    <div style="width:100%; height:250px; background:var(--border); border-radius:12px 12px 0 0; display:flex; align-items:center; justify-content:center; color:var(--text-muted);">Sin Imagen</div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info" style="padding: 20px;">
                                <h3 style="font-size: 1.1rem; margin-bottom: 8px; color: #fff;"><?php the_title(); ?></h3>
                                <div class="product-price" style="font-size: 1.25rem; font-weight: 700; color: var(--primary); margin-bottom: 16px; display: flex; flex-direction: column; gap: 4px;">
                                    <span>$<?php echo number_format((float)$price, 2); ?></span>
                                    <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 500;">Bs. <?php echo number_format($price_bs, 2, ',', '.'); ?></span>
                                </div>
                                <button type="button" class="button button-outline button-block add-to-cart-btn" 
                                    data-id="<?php the_ID(); ?>" 
                                    data-title="<?php echo esc_attr(get_the_title()); ?>" 
                                    data-price="<?php echo esc_attr($price); ?>"
                                    data-pricebs="<?php echo esc_attr($price_bs); ?>">
                                    Añadir al Pedido
                                </button>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <div class="pagination" style="margin-top: 40px; text-align: center;">
                <?php 
                echo paginate_links( array(
                    'total' => $products_query->max_num_pages,
                    'prev_text' => '&laquo; Anterior',
                    'next_text' => 'Siguiente &raquo;'
                ) );
                ?>
            </div>
            
        <?php else : ?>
            <div class="text-center" style="padding: 60px;">
                <h3>Esta tienda aún no tiene productos</h3>
            </div>
        <?php endif; wp_reset_postdata(); ?>
    </section>

</main>

<!-- Carrito Flotante (Se inyecta vía JS, pero aquí el contenedor) -->
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
