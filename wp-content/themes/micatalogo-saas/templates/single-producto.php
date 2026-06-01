<?php
/**
 * Single Producto
 */
get_header(); ?>
<main id="primary" class="site-main">
    <div class="container">
        <?php
        while ( have_posts() ) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header>
                <div class="entry-content">
                    <?php the_post_thumbnail(); ?>
                    <?php the_content(); ?>
                    <button class="add-to-cart-btn" data-product-id="<?php the_ID(); ?>">Añadir al carrito</button>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>
</main>
<?php get_footer(); ?>
