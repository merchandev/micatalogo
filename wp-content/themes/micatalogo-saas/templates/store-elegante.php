<main class="storefront template-elegante" style="background: var(--bg-dark); min-height: 100vh;">
    
    <!-- Header Split / Boutique -->
    <header class="storefront-header reveal-fade" style="padding: 60px 5%; display: flex; align-items: center; gap: 40px; border-bottom: 1px solid rgba(255,255,255,0.08); flex-wrap: wrap;">
        <div class="header-image" style="flex: 0 0 auto;">
            <?php if ( $logo_url ) : ?>
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $store_name ); ?>" class="store-logo" style="width: 120px; height: 120px; border-radius: 16px; object-fit: cover; box-shadow: 0 10px 30px rgba(0,0,0,0.6);">
            <?php else : ?>
                <div class="store-logo-placeholder" style="width: 120px; height: 120px; border-radius: 16px; background: #fff; color: #000; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: bold; box-shadow: 0 10px 30px rgba(0,0,0,0.6);"><?php echo substr($store_name, 0, 1); ?></div>
            <?php endif; ?>
        </div>
        
        <div class="header-text" style="flex: 1 1 300px;">
            <h1 class="store-name" style="font-size: 3rem; font-family: 'Playfair Display', serif, sans-serif; font-weight: 700; margin-bottom: 10px; letter-spacing: -0.5px;"><?php echo esc_html( $store_name ); ?></h1>
            <?php if ( $store_desc ) : ?>
                <p class="store-desc" style="font-size: 1.15rem; color: #9CA3AF; max-width: 600px; font-weight: 300; line-height: 1.6;"><?php echo esc_html( $store_desc ); ?></p>
            <?php endif; ?>
        </div>
    </header>

    <!-- Listado de Productos (Boutique List Layout) -->
    <section class="store-catalog" style="padding: 60px 5%; max-width: 1200px; margin: 0 auto;">
        <?php if ( !empty($products_page) ) : ?>
            <div class="products-list" style="display: flex; flex-direction: column; gap: 40px;">
                <?php foreach ( $products_page as $product ) : 
                    $price = $product->price;
                    $price_bs = (float)$price * (float)$exchange_rate;
                    $permalink = get_author_posts_url($vendor_id) . '?item=' . $product->id;
                    $image_url = $product->image_id ? wp_get_attachment_image_url($product->image_id, 'medium') : '';
                ?>
                    <article class="product-list-item reveal-up" style="display: flex; flex-wrap: wrap; gap: 30px; align-items: center; padding-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                        
                        <div class="product-image" style="flex: 0 0 300px; max-width: 100%;">
                            <a href="<?php echo esc_url($permalink); ?>">
                                <?php if ( $image_url ) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->title); ?>" style="width:100%; height:300px; object-fit:cover; border-radius:4px; transition: opacity 0.3s;">
                                <?php else : ?>
                                    <div style="width:100%; height:300px; background:#111; display:flex; align-items:center; justify-content:center; color:#666; border-radius:4px;">Sin Imagen</div>
                                <?php endif; ?>
                            </a>
                        </div>
                        
                        <div class="product-info" style="flex: 1 1 300px; padding: 20px 0;">
                            <a href="<?php echo esc_url($permalink); ?>" style="text-decoration: none; color: inherit;">
                                <h3 style="font-family: 'Playfair Display', serif, sans-serif; font-size: 1.8rem; margin-bottom: 16px; color: #fff; font-weight: 600;"><?php echo esc_html($product->title); ?></h3>
                            </a>
                            
                            <p style="color: #9CA3AF; margin-bottom: 24px; line-height: 1.6; max-width: 500px;">
                                <?php echo esc_html( wp_trim_words( $product->description, 20, '...' ) ); ?>
                            </p>

                            <div class="product-price" style="font-size: 1.5rem; font-weight: 500; color: #fff; margin-bottom: 24px; display: flex; align-items: baseline; gap: 12px;">
                                <span>$<?php echo number_format((float)$price, 2); ?></span>
                                <span style="font-size: 1rem; color: #6B7280; font-weight: 400;">(Bs. <?php echo number_format($price_bs, 2, ',', '.'); ?>)</span>
                            </div>
                            
                            <button type="button" class="button add-to-cart-btn" 
                                data-id="<?php echo esc_attr($product->id); ?>" 
                                data-title="<?php echo esc_attr($product->title); ?>" 
                                data-price="<?php echo esc_attr($price); ?>"
                                data-pricebs="<?php echo esc_attr($price_bs); ?>"
                                style="background: transparent; color: #fff; border: 1px solid #fff; padding: 12px 32px; border-radius: 0; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem; transition: all 0.3s;">
                                Añadir al Pedido
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <div class="pagination" style="margin-top: 60px; text-align: center; font-family: 'Playfair Display', serif, sans-serif;">
                <?php 
                $total_pages = ceil($total_products / $per_page);
                echo paginate_links( array(
                    'total' => $total_pages,
                    'current' => $paged,
                    'prev_text' => 'Anterior',
                    'next_text' => 'Siguiente'
                ) );
                ?>
            </div>
            
        <?php else : ?>
            <div class="text-center empty-state" style="padding: 100px 20px; font-family: 'Playfair Display', serif, sans-serif;">
                <h3 style="font-size: 2rem; color: #6B7280; font-weight: 400;">Colección Vacía</h3>
            </div>
        <?php endif; ?>
    </section>
</main>
