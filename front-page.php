<?php
/**
 * Plantilla principal de Portada (Front Page)
 * Si la asignación de página estática falla, esta plantilla actúa como fallback profesional.
 */

// Si está configurada una página estática, cargará su contenido. Si no, cargará esto.
if ( 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' ) ) {
    include( get_page_template() );
} else {
    get_header(); ?>
    <main class="public-page home">
        <div class="hero" style="text-align: center; padding: 100px 20px;">
            <h1>Bienvenido a <?php bloginfo( 'name' ); ?></h1>
            <p>La plataforma SaaS para catálogos y pedidos por WhatsApp.</p>
            <a href="/planes" class="button button-primary">Ver Planes</a>
        </div>
    </main>
    <?php get_footer();
}
?>
