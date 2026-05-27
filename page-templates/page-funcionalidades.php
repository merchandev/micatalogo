<?php
/**
 * Template Name: Página Pública - Funcionalidades
 */
get_header(); ?>

<main class="public-page features">
    <div class="container">
        <div class="features-header text-center reveal-up">
            <h1 class="text-gradient">Funcionalidades</h1>
            <p>Todo lo que necesitas para vender, sin complicaciones técnicas.</p>
        </div>

        <div class="features-detailed-grid" style="margin-top: 50px; display: grid; gap: 40px;">
            <div class="feature-row glass-card reveal-up delay-100" style="padding: 40px; display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
                <div class="feature-content" style="flex: 1; min-width: 300px;">
                    <h3><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">smartphone</span> Catálogo optimizado para celular</h3>
                    <p>Todas las plantillas se ven perfectas en teléfonos, que es donde están tus clientes. La navegación es intuitiva y rápida, como una aplicación nativa.</p>
                </div>
            </div>

            <div class="feature-row glass-card reveal-up delay-200" style="padding: 40px; display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
                <div class="feature-content" style="flex: 1; min-width: 300px;">
                    <h3><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">forum</span> Pedidos por WhatsApp inteligente</h3>
                    <p>El cliente arma su carrito y al finalizar se genera un mensaje con el detalle, total y sus datos. Solo debe pulsar "Enviar" y te llega ordenado directamente a tu WhatsApp personal.</p>
                </div>
            </div>

            <div class="feature-row glass-card reveal-up delay-300" style="padding: 40px; display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
                <div class="feature-content" style="flex: 1; min-width: 300px;">
                    <h3><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">currency_exchange</span> Precios en Bs y USD simultáneos</h3>
                    <p>Fija el precio en dólares y el sistema calculará automáticamente el equivalente en bolívares según la tasa que elijas (BCV o paralela). Tus clientes ven ambos precios sin confusión.</p>
                </div>
            </div>

            <div class="feature-row glass-card reveal-up delay-400" style="padding: 40px; display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
                <div class="feature-content" style="flex: 1; min-width: 300px;">
                    <h3><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">handshake</span> Red de revendedores</h3>
                    <p>Crea una cuenta maestra y asigna revendedores. Cada uno comparte su versión del catálogo (puedes ocultar precios o personalizarlos). Tú recibes el pedido final y gestionas la logística.</p>
                </div>
            </div>

            <div class="feature-row glass-card reveal-up delay-500" style="padding: 40px; display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
                <div class="feature-content" style="flex: 1; min-width: 300px;">
                    <h3><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">smart_toy</span> Inteligencia Artificial</h3>
                    <p>Escribe "Zapatos deportivos" y la IA te generará una descripción profesional en segundos. Además, puedes pedirle que analice qué productos tienen más visitas o qué estrategias usar.</p>
                </div>
            </div>

            <div class="feature-row glass-card reveal-up delay-600" style="padding: 40px; display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
                <div class="feature-content" style="flex: 1; min-width: 300px;">
                    <h3><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">bar_chart</span> Panel de control intuitivo</h3>
                    <p>Desde tu dashboard ves los pedidos pendientes, el rendimiento de tus productos y gestionas todo sin salir del celular.</p>
                </div>
            </div>
        </div>
        
        <div class="cta-section text-center reveal-scale" style="padding: 80px 0;">
            <a href="/autenticacion/?action=register" class="button button-primary" style="padding: 15px 40px; font-size: 1.1rem;">Ver demo en vivo (Crear cuenta gratis)</a>
        </div>
    </div>
</main>

<?php get_footer(); ?>
