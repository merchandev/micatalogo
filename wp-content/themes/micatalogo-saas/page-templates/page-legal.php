<?php
/**
 * Template Name: Página Pública - Legal
 */
get_header(); ?>

<main class="public-page legal">
    <div class="container legal-container">
        <div class="legal-header">
            <h1><?php the_title(); ?></h1>
            <p class="last-updated">Última actualización: <?php echo get_the_modified_date(); ?></p>
        </div>
        
        <div class="legal-content">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    $content = get_the_content();
                    if ( empty( $content ) ) {
                        // Texto genérico de placeholder si está vacío
                        echo '<h2>1. Condiciones de Uso</h2>';
                        echo '<p>Este es un texto de ejemplo para la página legal. Si eres el administrador, puedes editar esta página desde el panel de WordPress para añadir tus propios términos y condiciones, políticas de privacidad o políticas de cookies.</p>';
                        echo '<h2>2. Registro de Usuario</h2>';
                        echo '<p>Para utilizar el servicio de creación de catálogos, el usuario debe registrarse proporcionando información veraz.</p>';
                        echo '<h2>3. Uso del Servicio</h2>';
                        echo '<p>El usuario se compromete a no utilizar la plataforma para vender productos ilegales, no autorizados o que infrinjan derechos de autor.</p>';
                    } else {
                        the_content();
                    }
                endwhile;
            endif;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
