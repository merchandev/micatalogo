<?php
/**
 * Checkout por WhatsApp
 */
get_header(); ?>
<main id="primary" class="site-main">
    <div class="container">
        <h1>Pedido por WhatsApp</h1>
        <form id="whatsapp-checkout-form">
            <p>
                <label for="client_name">Nombre completo</label>
                <input type="text" id="client_name" name="client_name" required>
            </p>
            <p>
                <label for="client_phone">Teléfono (con código de país)</label>
                <input type="tel" id="client_phone" name="client_phone" required>
            </p>
            <p>
                <label for="client_address">Dirección de entrega</label>
                <textarea id="client_address" name="client_address"></textarea>
            </p>
            <p>
                <label for="client_notes">Notas del pedido</label>
                <textarea id="client_notes" name="client_notes"></textarea>
            </p>
            <?php echo do_shortcode('[micatalogo_whatsapp_button]'); ?>
        </form>
    </div>
</main>
<?php get_footer(); ?>
