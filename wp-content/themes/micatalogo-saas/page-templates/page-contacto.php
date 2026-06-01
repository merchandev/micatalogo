<?php
/**
 * Template Name: Página Pública - Contacto
 */
get_header(); ?>

<main class="public-page contact">
    <div class="container">
        <div class="contact-wrapper">
            <div class="contact-info">
                <h1>Hablemos</h1>
                <p>¿Tienes dudas sobre los planes o necesitas ayuda configurando tu catálogo? Estamos aquí para ayudarte.</p>
                
                <div class="contact-card glass-card" style="margin-bottom: 20px; padding: 20px;">
                    <div class="icon" style="margin-bottom: 10px;"><span class="material-symbols-outlined" style="font-size: 2.5rem; color: #10B981;">forum</span></div>
                    <div>
                        <h4>Atención principal: Vía WhatsApp</h4>
                        <p>Lunes a viernes de 9:00 am a 6:00 pm (hora de Venezuela)</p>
                        <a href="#" class="button button-whatsapp" style="margin-top: 10px; display: inline-block;">Escríbenos al WhatsApp</a>
                    </div>
                </div>

                <div class="contact-card glass-card" style="margin-bottom: 20px; padding: 20px;">
                    <div class="icon" style="margin-bottom: 10px;"><span class="material-symbols-outlined" style="font-size: 2.5rem; color: #3B82F6;">mail</span></div>
                    <div>
                        <h4>Correo Electrónico</h4>
                        <p>soporte@micatalogo.com.ve</p>
                    </div>
                </div>

                <div class="contact-card glass-card" style="padding: 20px;">
                    <div class="icon" style="margin-bottom: 10px;"><span class="material-symbols-outlined" style="font-size: 2.5rem; color: #F59E0B;">groups</span></div>
                    <div>
                        <h4>Comunidad de WhatsApp</h4>
                        <p>Únete donde emprendedores comparten tips y resuelven dudas entre todos.</p>
                        <a href="#" class="button button-outline" style="margin-top: 10px; display: inline-block;">Unirme al grupo</a>
                    </div>
                </div>
            </div>

            <div class="contact-form-container">
                <h3>Envíanos un mensaje</h3>
                <form class="contact-form" action="#" method="POST">
                    <div class="form-group">
                        <label for="name">Nombre Completo</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Mensaje</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="button button-primary button-block">Enviar Mensaje</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
