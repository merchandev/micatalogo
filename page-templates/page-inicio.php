<?php
/**
 * Template Name: Página Pública - Inicio
 */
get_header(); ?>

<main class="public-page home">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-container reveal-up">
            <div class="hero-badge delay-100 reveal-up"><span class="material-symbols-outlined" style="vertical-align: middle; font-size: 1.2rem; margin-right: 5px;">rocket_launch</span> Lanza tu negocio al siguiente nivel</div>
            <h1 class="text-gradient">Tu negocio en línea, <span class="text-gradient-accent">sin complicaciones</span></h1>
            <p class="reveal-up delay-100">Crea tu catálogo digital, vende por WhatsApp y cobra como prefieras: Pago Móvil, transferencia o dólares.</p>
            <div class="hero-actions reveal-up delay-200">
                <a href="/autenticacion/?action=register" class="button button-primary">Crear mi catálogo gratis</a>
                <a href="#como-funciona" class="button button-outline">Ver demo</a>
            </div>
            
            <div class="hero-stats reveal-fade delay-300" style="margin-bottom: 40px; color: var(--text-muted); font-size: 0.95rem; font-weight: 500;">
                <span class="material-symbols-outlined" style="vertical-align: middle; font-size: 1.2rem; color: #F59E0B;">star</span> Calificado con 4.9/5 por más de <strong style="color:var(--text-main);">500</strong> emprendedores venezolanos.
            </div>

            <!-- Mockup de la plataforma (Placeholder SVG) -->
            <div class="hero-image reveal-scale delay-300" style="position: relative; max-width: 900px; margin: 0 auto;">
                <!-- Desktop Mockup (Dashboard) -->
                <svg viewBox="0 0 800 500" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: auto; filter: drop-shadow(0 25px 50px rgba(0,0,0,0.5));">
                    <!-- Main Window -->
                    <rect x="0" y="0" width="800" height="500" rx="12" fill="#09090b" stroke="#27272a" stroke-width="2"/>
                    
                    <!-- Sidebar -->
                    <rect x="0" y="0" width="160" height="500" rx="12" fill="#18181b"/>
                    <!-- Logo Area -->
                    <circle cx="30" cy="40" r="12" fill="url(#brand-gradient)"/>
                    <rect x="55" y="35" width="70" height="10" rx="3" fill="#ffffff" fill-opacity="0.9"/>
                    
                    <!-- Menu Items -->
                    <rect x="20" y="80" width="120" height="30" rx="6" fill="#27272a"/>
                    <rect x="20" y="120" width="100" height="20" rx="4" fill="#27272a" fill-opacity="0.5"/>
                    <rect x="20" y="155" width="110" height="20" rx="4" fill="#27272a" fill-opacity="0.5"/>
                    <rect x="20" y="190" width="90" height="20" rx="4" fill="#27272a" fill-opacity="0.5"/>
                    <rect x="20" y="225" width="105" height="20" rx="4" fill="#27272a" fill-opacity="0.5"/>
                    
                    <!-- Header -->
                    <rect x="160" y="0" width="640" height="70" fill="#09090b"/>
                    <line x1="160" y1="70" x2="800" y2="70" stroke="#27272a" stroke-width="1"/>
                    <rect x="190" y="20" width="200" height="30" rx="6" fill="#18181b" stroke="#27272a" stroke-width="1"/>
                    <circle cx="750" cy="35" r="15" fill="#27272a"/>

                    <!-- Dashboard Content -->
                    <rect x="190" y="100" width="150" height="15" rx="4" fill="#ffffff" fill-opacity="0.9"/>
                    <rect x="190" y="125" width="250" height="10" rx="3" fill="#a1a1aa"/>

                    <!-- Stats Cards -->
                    <g transform="translate(190, 160)">
                        <rect x="0" y="0" width="180" height="90" rx="8" fill="#18181b" stroke="#27272a" stroke-width="1"/>
                        <rect x="15" y="15" width="60" height="10" rx="3" fill="#a1a1aa"/>
                        <rect x="15" y="35" width="90" height="20" rx="4" fill="#ffffff"/>
                        <rect x="15" y="65" width="40" height="10" rx="3" fill="#10b981"/>
                    </g>
                    <g transform="translate(390, 160)">
                        <rect x="0" y="0" width="180" height="90" rx="8" fill="#18181b" stroke="#27272a" stroke-width="1"/>
                        <rect x="15" y="15" width="60" height="10" rx="3" fill="#a1a1aa"/>
                        <rect x="15" y="35" width="90" height="20" rx="4" fill="#ffffff"/>
                        <rect x="15" y="65" width="40" height="10" rx="3" fill="#10b981"/>
                    </g>
                    <g transform="translate(590, 160)">
                        <rect x="0" y="0" width="180" height="90" rx="8" fill="#18181b" stroke="#27272a" stroke-width="1"/>
                        <rect x="15" y="15" width="60" height="10" rx="3" fill="#a1a1aa"/>
                        <rect x="15" y="35" width="90" height="20" rx="4" fill="#ffffff"/>
                        <rect x="15" y="65" width="40" height="10" rx="3" fill="#10b981"/>
                    </g>

                    <!-- Chart Area -->
                    <rect x="190" y="270" width="380" height="200" rx="8" fill="#18181b" stroke="#27272a" stroke-width="1"/>
                    <path d="M210 430 Q250 350 290 380 T370 290 T450 330 T530 290" stroke="url(#brand-gradient)" stroke-width="4" fill="none" stroke-linecap="round"/>
                    <path d="M210 450 L210 430 Q250 350 290 380 T370 290 T450 330 T530 290 L530 450 Z" fill="url(#chart-fade)" opacity="0.2"/>
                    
                    <!-- Recent Orders -->
                    <rect x="590" y="270" width="180" height="200" rx="8" fill="#18181b" stroke="#27272a" stroke-width="1"/>
                    <rect x="605" y="290" width="80" height="10" rx="3" fill="#ffffff"/>
                    
                    <circle cx="620" cy="330" r="12" fill="#27272a"/>
                    <rect x="640" y="325" width="60" height="8" rx="2" fill="#a1a1aa"/>
                    <rect x="640" y="337" width="40" height="6" rx="2" fill="#3f3f46"/>

                    <circle cx="620" cy="370" r="12" fill="#27272a"/>
                    <rect x="640" y="365" width="70" height="8" rx="2" fill="#a1a1aa"/>
                    <rect x="640" y="377" width="50" height="6" rx="2" fill="#3f3f46"/>
                    
                    <circle cx="620" cy="410" r="12" fill="#27272a"/>
                    <rect x="640" y="405" width="65" height="8" rx="2" fill="#a1a1aa"/>
                    <rect x="640" y="417" width="45" height="6" rx="2" fill="#3f3f46"/>

                    <!-- Defs -->
                    <defs>
                        <linearGradient id="brand-gradient" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#10b981"/>
                            <stop offset="100%" stop-color="#3b82f6"/>
                        </linearGradient>
                        <linearGradient id="chart-fade" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#10b981"/>
                            <stop offset="100%" stop-color="#09090b" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                </svg>

                <!-- Mobile Mockup (iPhone overlapping) -->
                <svg viewBox="0 0 240 500" fill="none" xmlns="http://www.w3.org/2000/svg" style="position: absolute; right: -20px; bottom: -40px; width: 220px; height: auto; filter: drop-shadow(-10px 20px 30px rgba(0,0,0,0.8));">
                    <!-- Phone Frame -->
                    <rect x="10" y="10" width="220" height="480" rx="35" fill="#09090b" stroke="#3f3f46" stroke-width="6"/>
                    <rect x="10" y="10" width="220" height="480" rx="35" fill="none" stroke="#18181b" stroke-width="2"/>
                    
                    <!-- Dynamic Island / Notch -->
                    <rect x="80" y="20" width="80" height="25" rx="12.5" fill="#000000"/>
                    
                    <!-- Screen Content (Storefront) -->
                    <!-- Header -->
                    <rect x="20" y="60" width="200" height="40" fill="#18181b" rx="8"/>
                    <circle cx="45" cy="80" r="10" fill="#27272a"/>
                    <rect x="65" y="75" width="80" height="10" rx="3" fill="#ffffff"/>
                    
                    <!-- Product Grid -->
                    <rect x="20" y="120" width="95" height="120" rx="12" fill="#18181b"/>
                    <rect x="20" y="120" width="95" height="80" rx="12" fill="#27272a"/>
                    <rect x="30" y="210" width="60" height="8" rx="2" fill="#ffffff"/>
                    <rect x="30" y="222" width="40" height="6" rx="2" fill="#10b981"/>
                    
                    <rect x="125" y="120" width="95" height="120" rx="12" fill="#18181b"/>
                    <rect x="125" y="120" width="95" height="80" rx="12" fill="#27272a"/>
                    <rect x="135" y="210" width="60" height="8" rx="2" fill="#ffffff"/>
                    <rect x="135" y="222" width="40" height="6" rx="2" fill="#10b981"/>

                    <rect x="20" y="250" width="95" height="120" rx="12" fill="#18181b"/>
                    <rect x="20" y="250" width="95" height="80" rx="12" fill="#27272a"/>
                    <rect x="30" y="340" width="60" height="8" rx="2" fill="#ffffff"/>
                    <rect x="30" y="352" width="40" height="6" rx="2" fill="#10b981"/>

                    <!-- Sticky WhatsApp Button -->
                    <rect x="20" y="420" width="200" height="45" rx="22.5" fill="#10b981"/>
                    <rect x="70" y="437" width="100" height="10" rx="3" fill="#ffffff"/>
                    <!-- Home indicator -->
                    <rect x="85" y="475" width="70" height="4" rx="2" fill="#ffffff" fill-opacity="0.3"/>
                </svg>
                
                <!-- Floating Glowing Orbs -->
                <div style="position: absolute; top: -50px; left: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; z-index: -1; filter: blur(40px);"></div>
                <div style="position: absolute; bottom: -50px; right: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; z-index: -1; filter: blur(40px);"></div>
            </div>
        </div>
    </section>

    <!-- Beneficios Rápidos -->
    <section class="features-section" style="padding: 80px 0;">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card glass-card reveal-up delay-100">
                    <div class="icon-svg" style="color: #10B981; margin-bottom: 15px;"><span class="material-symbols-outlined" style="font-size: 2.5rem;">timer</span></div>
                    <h3>En 5 minutos</h3>
                    <p>Elige una plantilla, sube tus productos y comparte el enlace.</p>
                </div>
                <div class="feature-card glass-card reveal-up delay-200">
                    <div class="icon-svg" style="color: #3B82F6; margin-bottom: 15px;"><span class="material-symbols-outlined" style="font-size: 2.5rem;">forum</span></div>
                    <h3>Pedidos por WhatsApp</h3>
                    <p>Tus clientes arman su pedido y te escriben directo al WhatsApp con todo listo.</p>
                </div>
                <div class="feature-card glass-card reveal-up delay-300">
                    <div class="icon-svg" style="color: #F59E0B; margin-bottom: 15px;"><span class="material-symbols-outlined" style="font-size: 2.5rem;">payments</span></div>
                    <h3>Cobro flexible</h3>
                    <p>Acepta pagos en bolívares (Pago Móvil, transferencia) o en dólares (Zelle, Uphold). Tú decides.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Por qué MiCatálogo Venezuela -->
    <section class="features-section" style="background: var(--bg-surface); padding: 100px 0;">
        <div class="container">
            <h2 class="section-title text-gradient reveal-up text-center">¿Por qué MiCatálogo Venezuela?</h2>
            
            <div class="features-grid" style="margin-top: 50px;">
                <div class="feature-card glass-card reveal-up delay-100">
                    <h3><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">public</span> Diseño pensado para el país</h3>
                    <p>Mostramos precios en bolívares y dólares automáticamente, con tasas actualizadas.</p>
                </div>
                <div class="feature-card glass-card reveal-up delay-200">
                    <h3><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">handshake</span> Ideal para revendedores</h3>
                    <p>Crea un catálogo matriz y comparte versiones personalizadas con tu red de revendedores. Ellos venden, tú ganas.</p>
                </div>
                <div class="feature-card glass-card reveal-up delay-300">
                    <h3><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">smart_toy</span> Asistente con Inteligencia Artificial</h3>
                    <p>Escribe descripciones de productos atractivas en segundos, sin ser experto en marketing.</p>
                </div>
                <div class="feature-card glass-card reveal-up delay-400">
                    <h3><span class="material-symbols-outlined" style="vertical-align: middle; margin-right: 8px;">smartphone</span> Sin instalaciones ni programación</h3>
                    <p>Solo necesitas tu teléfono. Todo funciona maravillosamente desde el navegador.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cómo Funciona -->
    <section id="como-funciona" class="steps-section" style="padding: 100px 0;">
        <div class="container">
            <h2 class="section-title text-gradient reveal-up text-center">Cómo funciona</h2>
            
            <div class="steps-grid" style="margin-top: 50px;">
                <div class="step-card glass-card reveal-up delay-100">
                    <div class="step-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">1</div>
                    <h3>Regístrate gratis</h3>
                    <p>Elige el plan que mejor se adapte a ti.</p>
                </div>
                <div class="step-card glass-card reveal-up delay-200">
                    <div class="step-icon" style="background: rgba(59, 130, 246, 0.1); color: #3B82F6;">2</div>
                    <h3>Añade tus productos</h3>
                    <p>Fotos, precio, descripción. La IA te ayuda a redactar.</p>
                </div>
                <div class="step-card glass-card reveal-up delay-300">
                    <div class="step-icon" style="background: rgba(139, 92, 246, 0.1); color: #8B5CF6;">3</div>
                    <h3>Comparte tu enlace</h3>
                    <p>Tus clientes navegan, seleccionan y te hacen el pedido por WhatsApp.</p>
                </div>
                <div class="step-card glass-card reveal-up delay-400">
                    <div class="step-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">4</div>
                    <h3>Recibe el pedido y cobra</h3>
                    <p>Te llega un mensaje con el resumen del pedido y los datos del cliente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="testimonials-section" style="background: var(--bg-surface); padding: 80px 0;">
        <div class="container">
            <h2 class="section-title text-gradient reveal-up text-center">Historias reales de crecimiento</h2>
            <div class="testimonials-grid" style="margin-top: 50px;">
                <div class="testimonial-card glass-card reveal-up delay-100">
                    <div class="testimonial-stars" style="color: #F59E0B; margin-bottom: 15px; font-size: 1.2rem;">
                        <span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span>
                    </div>
                    <p class="testimonial-text">"Antes anotaba todo en cuadernos. Ahora mis clientas me escriben por WhatsApp con el pedido hecho. ¡Gané tiempo y ventas!"</p>
                    <div class="testimonial-author" style="margin-top: 20px;">
                        <div class="testimonial-author-info">
                            <h4 style="margin: 0; color: #FFF;">Mariela G.</h4>
                            <span style="color: var(--text-muted); font-size: 0.85rem;">Emprendedora de cosméticos, Caracas</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card glass-card reveal-up delay-200">
                    <div class="testimonial-stars" style="color: #F59E0B; margin-bottom: 15px; font-size: 1.2rem;">
                        <span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span>
                    </div>
                    <p class="testimonial-text">"La opción de revendedores me cambió el juego. Mis amigas usan mi catálogo y ganan su comisión. Yo vendo más sin hacer nada extra."</p>
                    <div class="testimonial-author" style="margin-top: 20px;">
                        <div class="testimonial-author-info">
                            <h4 style="margin: 0; color: #FFF;">Luis R.</h4>
                            <span style="color: var(--text-muted); font-size: 0.85rem;">Distribuidor de calzado, Maracaibo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="cta-section text-center reveal-scale" style="padding: 100px 0;">
        <div class="container">
            <div class="glass-card" style="padding: 60px 40px; border-radius: 20px; background: linear-gradient(145deg, rgba(39,39,42,0.6) 0%, rgba(24,24,27,0.8) 100%);">
                <h2 class="text-gradient" style="font-size: 2.5rem; margin-bottom: 20px;">Empieza hoy y lleva tu negocio al siguiente nivel</h2>
                <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 40px; max-width: 600px; margin-left: auto; margin-right: auto;">Más de 500 emprendedores venezolanos ya confían en MiCatálogo. Únete gratis.</p>
                <a href="/autenticacion/?action=register" class="button button-primary" style="padding: 15px 40px; font-size: 1.1rem;">Probar ahora</a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
