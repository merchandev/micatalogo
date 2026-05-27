<?php
/**
 * Archive Producto
 */
get_header(); ?>
<main id="primary" class="site-main">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Catálogo de Productos</h1>
        </header>
        <div class="product-grid">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    get_template_part( 'template-parts/content', 'producto' );
                endwhile;
            else :
                echo '<p>No hay productos disponibles.</p>';
            endif;
            ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>
