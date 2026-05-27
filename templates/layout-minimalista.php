<?php
/**
 * Layout Minimalista
 */
get_header(); ?>
<main id="primary" class="site-main layout-minimalista">
    <div class="container">
        <h1>Tienda Minimalista</h1>
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</main>
<?php get_footer(); ?>
