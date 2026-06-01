<?php
/**
 * Template Name: Página Pública - Tutoriales
 */
get_header(); ?>

<main class="public-page tutorials">
    <div class="container">
        <div class="tutorials-header text-center">
            <h1>Centro de Ayuda y Tutoriales</h1>
            <p>Aprende a sacarle el máximo partido a tu tienda.</p>
            <div class="search-bar">
                <input type="text" placeholder="Buscar tutoriales (Ej: Cómo subir productos)...">
                <button class="button button-primary">Buscar</button>
            </div>
        </div>

        <div class="tutorials-grid">
            <div class="tutorial-card">
                <div class="tutorial-video-placeholder">▶</div>
                <div class="tutorial-content">
                    <h3>Primeros pasos: Crear tu tienda</h3>
                    <p>Configura el nombre de tu marca, tu logo y la información básica de contacto.</p>
                    <a href="#">Ver guía &rarr;</a>
                </div>
            </div>
            <div class="tutorial-card">
                <div class="tutorial-video-placeholder">▶</div>
                <div class="tutorial-content">
                    <h3>Cómo subir productos y variantes</h3>
                    <p>Aprende a añadir productos, establecer precios y configurar tallas/colores.</p>
                    <a href="#">Ver guía &rarr;</a>
                </div>
            </div>
            <div class="tutorial-card">
                <div class="tutorial-video-placeholder">▶</div>
                <div class="tutorial-content">
                    <h3>Cómo procesar un pedido de WhatsApp</h3>
                    <p>Entiende cómo llega el mensaje a tu WhatsApp y cómo gestionar el inventario.</p>
                    <a href="#">Ver guía &rarr;</a>
                </div>
            </div>
            <div class="tutorial-card">
                <div class="tutorial-video-placeholder">▶</div>
                <div class="tutorial-content">
                    <h3>Personalización de diseño</h3>
                    <p>Cambia el tema de tu catálogo, elige colores primarios y dale estilo a tu web.</p>
                    <a href="#">Ver guía &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
