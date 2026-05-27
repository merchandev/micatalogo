<?php
/**
 * Template Name: Onboarding SaaS
 */

if ( ! is_user_logged_in() ) {
    wp_redirect( site_url( '/autenticacion/' ) );
    exit;
}

$user = wp_get_current_user();
$store_name = get_user_meta( $user->ID, 'store_name', true );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración Inicial - <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
    <style>
        body.onboarding-page { background-color: var(--bg-dark); color: var(--text-main); display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .onboarding-container { max-width: 600px; width: 100%; padding: 40px; }
        .onboarding-card { padding: 48px; border-radius: 24px; text-align: center; }
        .progress-bar { width: 100%; height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; margin-bottom: 40px; overflow: hidden; }
        .progress-fill { height: 100%; width: 50%; background: var(--primary); transition: width 0.4s ease; }
        
        h1 { font-size: 2.5rem; margin-bottom: 16px; }
        p.subtitle { color: var(--text-muted); margin-bottom: 40px; font-size: 1.1rem; }
        
        .form-group { text-align: left; }
        .file-upload-wrapper { position: relative; width: 100%; border: 2px dashed var(--border); border-radius: var(--radius); padding: 32px; text-align: center; cursor: pointer; transition: var(--transition); }
        .file-upload-wrapper:hover { border-color: var(--primary); background: rgba(16, 185, 129, 0.05); }
        .file-upload-wrapper input[type="file"] { position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; }
    </style>
</head>
<body class="onboarding-page">

    <div class="onboarding-container">
        <div class="glass-card onboarding-card reveal-up">
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>

            <h1 class="text-gradient">¡Hola, <?php echo esc_html( $store_name ?: 'Vendedor' ); ?>!</h1>
            <p class="subtitle">Solo necesitamos dos datos para conectar tu tienda y empezar a recibir pedidos hoy mismo.</p>

            <form method="POST" action="" enctype="multipart/form-data">
                <?php wp_nonce_field( 'micatalogo_onboarding_action', 'micatalogo_onboarding_nonce' ); ?>
                
                <div class="form-group reveal-up delay-100">
                    <label for="whatsapp">Número de WhatsApp (Ventas)</label>
                    <input type="text" id="whatsapp" name="whatsapp" placeholder="Ej: +52 1 555 123 4567" required>
                    <small style="color:var(--text-muted); margin-top:8px; display:block;">Aquí es donde tus clientes te enviarán los carritos de compra.</small>
                </div>

                <div class="form-group reveal-up delay-200" style="margin-top: 24px;">
                    <label>Logo de tu Tienda (Opcional por ahora)</label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="store_logo" accept="image/*">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" style="margin-bottom:16px;">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        <p style="margin:0; color:var(--text-main);">Haz clic o arrastra tu logo aquí</p>
                    </div>
                </div>

                <button type="submit" class="button button-primary button-block reveal-up delay-300" style="margin-top: 40px; font-size: 1.1rem; padding: 18px;">Terminar y Entrar al Panel</button>
            </form>
        </div>
    </div>

    <?php wp_footer(); ?>
    <script>
        // Efecto visual rápido al subir logo
        const fileInput = document.querySelector('input[type="file"]');
        const fileText = document.querySelector('.file-upload-wrapper p');
        
        fileInput.addEventListener('change', (e) => {
            if(e.target.files.length > 0) {
                fileText.textContent = "Logo seleccionado: " + e.target.files[0].name;
                fileText.style.color = "var(--primary)";
            }
        });
    </script>
</body>
</html>
