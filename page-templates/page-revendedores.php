<?php
/**
 * Template Name: Página Pública - Revendedores
 */
get_header(); ?>

<main class="public-page resellers">
    <div class="container">
        <div class="resellers-header text-center reveal-up">
            <h1 class="text-gradient">¿Tienes un negocio y quieres que otros vendan por ti?</h1>
            <p>Nuestro sistema de catálogos para revendedores te permite multiplicar tus ventas sin esfuerzo extra.</p>
        </div>

        <div class="resellers-content glass-card reveal-up delay-100" style="margin-top: 50px; padding: 50px;">
            <div class="features-list" style="max-width: 800px; margin: 0 auto;">
                <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 20px;">
                    <li style="display: flex; gap: 15px; align-items: flex-start;">
                        <span class="material-symbols-outlined" style="color: #10B981; font-size: 1.5rem;">check_circle</span>
                        <div>
                            <strong style="font-size: 1.2rem; display: block; margin-bottom: 5px;">Catálogo Maestro</strong>
                            <p style="color: var(--text-muted); margin: 0;">Crea un catálogo principal con todos tus productos y precios base. Este será la fuente de verdad de tu negocio.</p>
                        </div>
                    </li>
                    <li style="display: flex; gap: 15px; align-items: flex-start;">
                        <span class="material-symbols-outlined" style="color: #10B981; font-size: 1.5rem;">check_circle</span>
                        <div>
                            <strong style="font-size: 1.2rem; display: block; margin-bottom: 5px;">Accesos Independientes</strong>
                            <p style="color: var(--text-muted); margin: 0;">Dar acceso a tus revendedores (con su propio usuario) para que ellos compartan el catálogo con su red.</p>
                        </div>
                    </li>
                    <li style="display: flex; gap: 15px; align-items: flex-start;">
                        <span class="material-symbols-outlined" style="color: #10B981; font-size: 1.5rem;">check_circle</span>
                        <div>
                            <strong style="font-size: 1.2rem; display: block; margin-bottom: 5px;">Márgenes Configurables</strong>
                            <p style="color: var(--text-muted); margin: 0;">Configura comisiones o precios diferenciados para cada revendedor de forma sencilla.</p>
                        </div>
                    </li>
                    <li style="display: flex; gap: 15px; align-items: flex-start;">
                        <span class="material-symbols-outlined" style="color: #10B981; font-size: 1.5rem;">check_circle</span>
                        <div>
                            <strong style="font-size: 1.2rem; display: block; margin-bottom: 5px;">Pedidos Centralizados</strong>
                            <p style="color: var(--text-muted); margin: 0;">Recibe los pedidos consolidados directamente en tu WhatsApp con la información del revendedor y del cliente final.</p>
                        </div>
                    </li>
                </ul>

                <div class="highlight-box" style="margin-top: 40px; padding: 30px; background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10B981; border-radius: 0 8px 8px 0;">
                    <h3 style="margin: 0 0 10px 0; color: #10B981;">Tú vendes al por mayor y ellos al detal. Todos ganan.</h3>
                    <p style="margin: 0; color: var(--text-muted);">Empieza a armar tu red de distribución digital hoy mismo y escala tus ventas a todo el país.</p>
                </div>
            </div>
        </div>

        <div class="cta-section text-center reveal-scale" style="padding: 80px 0;">
            <a href="/autenticacion/?action=register" class="button button-primary" style="padding: 15px 40px; font-size: 1.1rem;">Comenzar red de revendedores</a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
