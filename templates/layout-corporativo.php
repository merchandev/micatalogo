<?php
/**
 * Layout Corporativo
 */
get_header(); ?>
<main id="primary" class="site-main layout-corporativo">
    <div class="container">
        <h1>Tienda Corporativa</h1>
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
