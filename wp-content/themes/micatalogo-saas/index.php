<?php
/**
 * Main template file (Requerido por WordPress)
 */
get_header(); ?>
<main id="primary" class="site-main">
    <div class="container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
        else :
            echo '<p>Contenido no encontrado.</p>';
        endif;
        ?>
    </div>
</main>
<?php get_footer(); ?>
