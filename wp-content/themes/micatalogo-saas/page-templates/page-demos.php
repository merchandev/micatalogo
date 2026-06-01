<?php
/**
 * Template Name: Página Pública - Demos
 */
get_header(); ?>

<main class="public-page demos">
    <div class="container">
        <div class="demos-header text-center reveal-up">
            <h1 class="text-gradient">Explora nuestras Demos</h1>
            <p>Descubre cómo se vería tu negocio en línea. Navega por estos catálogos de ejemplo creados con nuestra plataforma.</p>
        </div>

        <div class="demos-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 50px;">
            
            <!-- Demo 1: Moda -->
            <div class="demo-card glass-card reveal-up delay-100" style="padding: 20px; border-radius: 20px; text-align: center;">
                <div class="demo-preview" style="background: rgba(255,255,255,0.05); height: 200px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="font-size: 4rem; color: #10B981;">checkroom</span>
                </div>
                <h3>Boutique "La Moda"</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">Plantilla ideal para venta de ropa, calzado y accesorios con variantes de tallas y colores.</p>
                <a href="#" class="button button-primary button-block" onclick="alert('Esta es una demostración visual. En producción, esto te llevará a una tienda de ejemplo.')">Ver Demo Interactiva</a>
            </div>

            <!-- Demo 2: Comida Rápida -->
            <div class="demo-card glass-card reveal-up delay-200" style="padding: 20px; border-radius: 20px; text-align: center;">
                <div class="demo-preview" style="background: rgba(255,255,255,0.05); height: 200px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="font-size: 4rem; color: #F59E0B;">fastfood</span>
                </div>
                <h3>Burgers & Co.</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">Diseño optimizado para comida rápida, permitiendo seleccionar extras y combos fácilmente.</p>
                <a href="#" class="button button-primary button-block" onclick="alert('Esta es una demostración visual. En producción, esto te llevará a una tienda de ejemplo.')">Ver Demo Interactiva</a>
            </div>

            <!-- Demo 3: Electrónica -->
            <div class="demo-card glass-card reveal-up delay-300" style="padding: 20px; border-radius: 20px; text-align: center;">
                <div class="demo-preview" style="background: rgba(255,255,255,0.05); height: 200px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="font-size: 4rem; color: #3B82F6;">devices</span>
                </div>
                <h3>TechStore Venezuela</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 20px;">Perfecta para productos tecnológicos, destacando descripciones técnicas y garantías.</p>
                <a href="#" class="button button-primary button-block" onclick="alert('Esta es una demostración visual. En producción, esto te llevará a una tienda de ejemplo.')">Ver Demo Interactiva</a>
            </div>

        </div>

        <div class="cta-section text-center reveal-scale" style="padding: 80px 0;">
            <div class="glass-card" style="padding: 40px; border-radius: 20px; background: linear-gradient(145deg, rgba(16,185,129,0.1) 0%, rgba(0,0,0,0) 100%);">
                <h2 class="text-gradient">¿Listo para crear la tuya?</h2>
                <p style="color: var(--text-muted); margin-bottom: 30px;">Prueba todas nuestras funcionalidades registrándote gratis hoy.</p>
                <a href="/autenticacion/?action=register" class="button button-primary" style="padding: 15px 40px; font-size: 1.1rem;">Comenzar mi catálogo</a>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
