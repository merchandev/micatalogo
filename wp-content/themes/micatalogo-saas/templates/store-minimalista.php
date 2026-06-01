<main class="storefront template-minimalista" style="background: #000; min-height: 100vh; padding-top: 40px;">
    
    <!-- Header Minimalista -->
    <header class="storefront-header reveal-fade" style="padding: 0 40px 60px 40px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
        
        <div style="display: flex; align-items: center; gap: 20px;">
            <?php if ( $logo_url ) : ?>
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $store_name ); ?>" class="store-logo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
            <?php else : ?>
                <div class="store-logo-placeholder" style="width: 50px; height: 50px; border-radius: 50%; background: #fff; color: #000; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold;"><?php echo substr($store_name, 0, 1); ?></div>
            <?php endif; ?>
            <h1 class="store-name" style="font-size: 1.5rem; font-weight: 500; letter-spacing: 1px; margin: 0; color: #fff;"><?php echo esc_html( $store_name ); ?></h1>
        </div>
        
        <?php if ( $store_desc ) : ?>
            <p class="store-desc" style="font-size: 0.9rem; color: #888; max-width: 400px; margin: 0; text-align: right;"><?php echo esc_html( $store_desc ); ?></p>
        <?php endif; ?>
    </header>

    <!-- Grid Limpio de Productos -->
    <section class="store-catalog" style="padding: 0 40px 80px 40px;">
        <?php if ( !empty($products_page) ) : ?>
            <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 60px 40px;">
                <?php foreach ( $products_page as $product ) : 
                    $price = $product->price;
                    $price_bs = (float)$price * (float)$exchange_rate;
                    $permalink = get_author_posts_url($vendor_id) . '?producto=' . $product->id;
                    $image_url = $product->image_id ? wp_get_attachment_image_url($product->image_id, 'large') : '';
                ?>
                    <article class="product-item reveal-up" style="display: flex; flex-direction: column;">
                        <a href="<?php echo esc_url($permalink); ?>" class="product-link" style="text-decoration: none; display: block; margin-bottom: 20px;">
                            <div class="product-image" style="position: relative; overflow: hidden; padding-bottom: 125%; /* 4:5 aspect ratio */">
                                <?php if ( $image_url ) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);">
                                <?php else : ?>
                                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #111; display:flex; align-items:center; justify-content:center; color:#444;">Sin Imagen</div>
                                <?php endif; ?>
                            </div>
                        </a>
                        
                        <div class="product-info" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px;">
                            <div style="flex: 1;">
                                <a href="<?php echo esc_url($permalink); ?>" style="text-decoration: none; color: inherit;">
                                    <h3 style="font-size: 1rem; margin: 0 0 8px 0; color: #fff; font-weight: 400;"><?php echo esc_html($product->title); ?></h3>
                                </a>
                                <div class="product-price" style="font-size: 0.9rem; color: #888; display: flex; gap: 8px;">
                                    <span>$<?php echo number_format((float)$price, 2); ?></span>
                                    <span>&middot;</span>
                                    <span>Bs. <?php echo number_format($price_bs, 2, ',', '.'); ?></span>
                                </div>
                            </div>
                            
                            <button type="button" class="add-to-cart-btn" 
                                data-id="<?php echo esc_attr($product->id); ?>" 
                                data-title="<?php echo esc_attr($product->title); ?>" 
                                data-price="<?php echo esc_attr($price); ?>"
                                data-pricebs="<?php echo esc_attr($price_bs); ?>"
                                style="background: none; border: none; color: #fff; cursor: pointer; padding: 8px; margin: -8px; border-radius: 50%; transition: background 0.3s;"
                                aria-label="Añadir al pedido">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:24px; height:24px;"><path d="M12 5v14M5 12h14"></path></svg>
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <div class="pagination" style="margin-top: 80px; text-align: center;">
                <?php 
                $total_pages = ceil($total_products / $per_page);
                echo paginate_links( array(
                    'total' => $total_pages,
                    'current' => $paged,
                    'prev_text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width:20px; height:20px; vertical-align:middle;"><path d="M15 18l-6-6 6-6"></path></svg>',
                    'next_text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width:20px; height:20px; vertical-align:middle;"><path d="M9 18l6-6-6-6"></path></svg>'
                ) );
                ?>
            </div>
            
        <?php else : ?>
            <div class="text-center empty-state" style="padding: 100px 0; color: #444;">
                <p>No hay productos disponibles.</p>
            </div>
        <?php endif; ?>
    </section>
</main>
