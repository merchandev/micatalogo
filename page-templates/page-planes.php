<?php
/**
 * Template Name: Página Pública - Planes
 */
get_header(); ?>

<main class="public-page pricing">
    <div class="container">
        <div class="pricing-header text-center reveal-up">
            <h1 class="text-gradient">Planes para todo tipo de emprendedor</h1>
            <p>Los precios en bolívares se muestran a la tasa del día. Puedes pagar en $ o en Bs.</p>
        </div>

        <div class="pricing-table">
            <!-- Plan Básico -->
            <div class="pricing-card glass-card reveal-up delay-100">
                <h3>Básico</h3>
                <div class="price">Gratis<span>/siempre</span></div>
                <p class="plan-desc">Perfecto para empezar sin riesgos.</p>
                <ul class="features-list">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Hasta 10 productos</li>
                    <li class="disabled"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Sin Revendedores</li>
                    <li class="disabled"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Sin Asistente IA</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Estadísticas Básicas</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Soporte Comunidad</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Plantillas básicas</li>
                </ul>
                <a href="/autenticacion/?action=register&plan=basic" class="button button-outline button-block">Comenzar gratis</a>
            </div>

            <!-- Plan Pro -->
            <div class="pricing-card featured glass-card reveal-scale delay-200">
                <div class="badge">Más Popular</div>
                <h3>Pro</h3>
                <div class="price">$3,99<span>/mes</span></div>
                <p style="text-align:center; font-size: 0.8rem; color: var(--text-muted); margin-top: -10px; margin-bottom: 15px;">(aprox. Bs. 120 al día de hoy)</p>
                <p class="plan-desc">El motor definitivo para tiendas y negocios que venden todos los días.</p>
                <ul class="features-list">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Hasta 200 productos</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Hasta 5 catálogos (Revendedores)</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> 50 descripciones/mes IA</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Estadísticas Avanzadas</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Soporte WhatsApp + correo</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> 3 plantillas premium</li>
                </ul>
                <a href="/autenticacion/?action=register&plan=pro" class="button button-primary button-block">Elegir Pro</a>
            </div>

            <!-- Plan Empresarial -->
            <div class="pricing-card glass-card reveal-up delay-300">
                <h3>Empresarial</h3>
                <div class="price">$9,99<span>/mes</span></div>
                <p class="plan-desc">Para agencias, mayoristas y grandes catálogos con necesidades avanzadas.</p>
                <ul class="features-list">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Productos Ilimitados</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Hasta 50 catálogos (Revendedores)</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Descripciones Ilimitadas IA</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Estadísticas + reportes</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Soporte prioritario</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Plantillas premium + dominio propio</li>
                </ul>
                <a href="/autenticacion/?action=register&plan=empresa" class="button button-outline button-block">Elegir Empresarial</a>
            </div>
        </div>

        <div class="payment-methods text-center" style="margin-top: 40px; color: var(--text-muted);">
            <p><strong>Métodos de pago aceptados:</strong> Pago Móvil Interbancario, Transferencia bancaria (Bs), Zelle, Uphold, Reserve (USD), Tarjeta de crédito internacional.</p>
        </div>

        <!-- FAQ Section -->
        <div class="faq-section">
            <h2 class="text-center text-gradient reveal-up">Preguntas Frecuentes</h2>
            <div class="faq-grid">
                <div class="faq-item glass-card reveal-up">
                    <h4>¿Necesito tarjeta de crédito para empezar?</h4>
                    <p>No. El plan Básico es 100% gratis y no requiere ningún pago. Para actualizar a Pro puedes pagar en bolívares con Pago Móvil o transferencia.</p>
                </div>
                <div class="faq-item glass-card reveal-up">
                    <h4>¿Cómo recibo los pedidos?</h4>
                    <p>Cada vez que un cliente confirma su pedido, te llega un mensaje a tu WhatsApp con la lista de productos, cantidades, total y los datos de contacto. Tú te comunicas para coordinar la entrega y el pago.</p>
                </div>
                <div class="faq-item glass-card reveal-up">
                    <h4>¿Puedo mostrar precios en dólares y bolívares?</h4>
                    <p>Sí. Estableces el precio en dólares y el sistema muestra la conversión a bolívares según la tasa que configures. Puedes actualizar la tasa manualmente o dejar la automática (conexión a monitoreo BCV).</p>
                </div>
                <div class="faq-item glass-card reveal-up">
                    <h4>¿Qué son los catálogos para revendedores?</h4>
                    <p>Son réplicas de tu catálogo principal que puedes compartir con personas de confianza. Cada revendedor puede usar tu catálogo con su propio enlace, y los pedidos te llegan a ti. Ideal para modelos de reventa o preventa.</p>
                </div>
                <div class="faq-item glass-card reveal-up">
                    <h4>¿Puedo usar mi propio dominio?</h4>
                    <p>En los planes Pro y Empresarial puedes conectar un dominio personalizado (ej. tutienda.com.ve) para mayor profesionalismo.</p>
                </div>
                <div class="faq-item glass-card reveal-up">
                    <h4>¿Qué pasa si cancelo la suscripción?</h4>
                    <p>Tus datos no se pierden. Si bajas al plan Gratis, solo podrás tener 10 productos visibles, pero conservas todo lo demás.</p>
                </div>
                <div class="faq-item glass-card reveal-up">
                    <h4>¿Ofrecen facturación?</h4>
                    <p>Por ahora no emitimos facturas electrónicas, pero estamos trabajando en una integración con SENIAT para que pronto puedas facturar directamente desde la plataforma.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
