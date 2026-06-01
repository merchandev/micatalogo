<main class="storefront template-moderna">
    
    <!-- Header Clásico Centrado -->
    <header class="storefront-header text-center reveal-fade" style="padding: 60px 20px; background: linear-gradient(180deg, rgba(var(--primary-rgb), 0.1) 0%, transparent 100%); border-bottom: 1px solid rgba(255,255,255,0.05);">
        <div class="container">
            <?php if ( $logo_url ) : ?>
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $store_name ); ?>" class="store-logo" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
            <?php else : ?>
                <div class="store-logo-placeholder" style="width: 100px; height: 100px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: bold; margin: 0 auto 20px auto;"><?php echo substr($store_name, 0, 1); ?></div>
            <?php endif; ?>
            
            <h1 class="store-name" style="font-size: 2.5rem; font-weight: 800; margin-bottom: 10px;"><?php echo esc_html( $store_name ); ?></h1>
            <?php if ( $store_desc ) : ?>
                <p class="store-desc" style="font-size: 1.1rem; color: var(--text-muted); max-width: 600px; margin: 0 auto;"><?php echo esc_html( $store_desc ); ?></p>
            <?php endif; ?>
        </div>
    </header>

    <!-- Grid de Productos en Tarjetas (Cards) -->
    <section class="store-catalog container" style="padding: 60px 0;">
        <?php if ( !empty($products_page) ) : ?>
            <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 32px;">
                <?php foreach ( $products_page as $product ) : 
                    $price = $product->price;
                    $price_bs = (float)$price * (float)$exchange_rate;
                    $permalink = get_author_posts_url($vendor_id) . '?producto=' . $product->id;
                    $image_url = $product->image_id ? wp_get_attachment_image_url($product->image_id, 'medium') : '';
                ?>
                    <article class="product-card glass-card reveal-up" style="transition: transform 0.3s ease; border-radius: 12px; overflow: hidden;">
                        <a href="<?php echo esc_url($permalink); ?>" class="product-link" style="display: block; text-decoration: none; color: inherit;">
                            <div class="product-image">
                                <?php if ( $image_url ) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->title); ?>" style="width:100%; height:250px; object-fit:cover; transition: transform 0.5s ease;">
                                <?php else : ?>
                                    <div style="width:100%; height:250px; background:var(--bg-dark); display:flex; align-items:center; justify-content:center; color:var(--text-muted);">Sin Imagen</div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info" style="padding: 20px; text-align: left;">
                                <h3 style="font-size: 1.1rem; margin-bottom: 8px; color: #fff; line-height: 1.4;"><?php echo esc_html($product->title); ?></h3>
                                <div class="product-price" style="font-size: 1.25rem; font-weight: 700; color: var(--primary); margin-bottom: 16px; display: flex; flex-direction: column; gap: 4px;">
                                    <span>$<?php echo number_format((float)$price, 2); ?></span>
                                    <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 500;">Bs. <?php echo number_format($price_bs, 2, ',', '.'); ?></span>
                                </div>
                                <button type="button" class="button button-primary button-block add-to-cart-btn" 
                                    data-id="<?php echo esc_attr($product->id); ?>" 
                                    data-title="<?php echo esc_attr($product->title); ?>" 
                                    data-price="<?php echo esc_attr($price); ?>"
                                    data-pricebs="<?php echo esc_attr($price_bs); ?>"
                                    style="width: 100%; border-radius: 8px;">
                                    Añadir al Pedido
                                </button>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <div class="pagination" style="margin-top: 40px; text-align: center;">
                <?php 
                $total_pages = ceil($total_products / $per_page);
                echo paginate_links( array(
                    'total' => $total_pages,
                    'current' => $paged,
                    'prev_text' => '&laquo; Anterior',
                    'next_text' => 'Siguiente &raquo;'
                ) );
                ?>
            </div>
            
        <?php else : ?>
            <div class="text-center empty-state" style="padding: 60px; background: rgba(255,255,255,0.02); border-radius: 12px; margin: 40px 0;">
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" style="width: 48px; height: 48px; margin-bottom: 16px;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                <h3>Esta tienda aún no tiene productos</h3>
            </div>
        <?php endif; ?>
    </section>
</main>
