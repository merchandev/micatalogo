<?php
/**
 * Template Name: Autenticación SaaS
 */

// Si el usuario ya está logueado, redirigirlo al panel.
if ( is_user_logged_in() ) {
    wp_redirect( site_url( '/panel-vendedor/' ) );
    exit;
}

$action = isset( $_GET['action'] ) ? $_GET['action'] : 'login';
$error = isset( $_GET['error'] ) ? $_GET['error'] : '';

// No cargamos get_header() para tener una pantalla inmersiva y limpia.
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
    <style>
        /* Estilos específicos para no polucionar theme.css si no es necesario, aunque lo ideal es integrarlo. */
        body.auth-page { background-color: var(--bg-dark); overflow-x: hidden; margin: 0; padding: 0; }
        .auth-wrapper { display: flex; min-height: 100vh; width: 100%; }
        
        /* Columna Izquierda: Decorativa */
        .auth-sidebar { 
            flex: 1; 
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 5, 5, 1) 100%);
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            padding: 40px; position: relative; border-right: 1px solid var(--border);
            overflow: hidden;
        }
        @media(max-width: 900px) { .auth-sidebar { display: none; } }
        
        .auth-sidebar::before {
            content: ''; position: absolute; width: 600px; height: 600px;
            background: radial-gradient(circle, var(--accent-glow) 0%, transparent 60%);
            z-index: 0;
        }
        .sidebar-content { z-index: 1; text-align: center; max-width: 400px; }
        .sidebar-content h2 { font-size: 3rem; margin-bottom: 24px; }
        .sidebar-content p { color: var(--text-muted); font-size: 1.1rem; line-height: 1.6; }

        /* Columna Derecha: Formularios */
        .auth-main { 
            flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; 
            background-color: var(--bg-dark); padding: 40px;
        }
        .auth-form-container { width: 100%; max-width: 420px; }
        .auth-logo { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #fff; text-decoration: none; display: inline-block; margin-bottom: 48px; }
        
        .auth-title { font-size: 2.25rem; margin-bottom: 8px; }
        .auth-subtitle { color: var(--text-muted); margin-bottom: 32px; }
        
        .auth-error { background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #EF4444; padding: 16px; border-radius: var(--radius); margin-bottom: 24px; font-size: 0.95rem; }
        
        .auth-toggle { text-align: center; margin-top: 32px; color: var(--text-muted); }
        .auth-toggle a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .auth-toggle a:hover { text-decoration: underline; }
    </style>
</head>
<body class="auth-page">

    <div class="auth-wrapper">
        <!-- Sidebar -->
        <div class="auth-sidebar">
            <div class="sidebar-content reveal-up">
                <h2 class="text-gradient">Domina tus ventas</h2>
                <p>El estándar de la élite comercial. Empieza a vender sin comisiones desde tu propia plataforma conectada a WhatsApp.</p>
            </div>
        </div>

        <!-- Formularios -->
        <div class="auth-main">
            <div class="auth-form-container reveal-fade delay-200">
                <a href="<?php echo site_url(); ?>" class="auth-logo">MiCatálogo</a>

                <?php if ( $error === 'login_failed' ) : ?>
                    <div class="auth-error">Credenciales incorrectas. Verifica tu correo y contraseña.</div>
                <?php elseif ( $error === 'email_exists' ) : ?>
                    <div class="auth-error">Este correo ya está registrado. Inicia sesión.</div>
                <?php elseif ( $error === 'empty_fields' ) : ?>
                    <div class="auth-error">Por favor, completa todos los campos requeridos.</div>
                <?php elseif ( $error === 'nonce_failed' ) : ?>
                    <div class="auth-error">La sesión expiró. Por favor inténtalo de nuevo.</div>
                <?php elseif ( $error === 'creation_failed' ) : ?>
                    <div class="auth-error">Ocurrió un error al crear la cuenta. Informa a soporte.</div>
                <?php endif; ?>

                <?php if ( $action === 'login' ) : ?>
                    <!-- FORMULARIO DE LOGIN -->
                    <h1 class="auth-title">Bienvenido de vuelta</h1>
                    <p class="auth-subtitle">Ingresa tus credenciales para acceder a tu panel.</p>
                    
                    <form method="POST" action="<?php echo esc_url( get_permalink() ?: site_url('/autenticacion/') ); ?>">
                        <?php wp_nonce_field( 'micatalogo_auth_action', 'micatalogo_auth_nonce' ); ?>
                        <input type="hidden" name="auth_action" value="login">
                        
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" required autofocus>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        
                        <button type="submit" class="button button-primary button-block">Iniciar Sesión</button>
                    </form>

                    <div class="auth-toggle">
                        ¿No tienes una cuenta? <a href="?action=register">Crea tu tienda gratis</a>
                    </div>

                <?php else : ?>
                    <!-- FORMULARIO DE REGISTRO -->
                    <h1 class="auth-title">Crea tu tienda</h1>
                    <p class="auth-subtitle">Estarás online en menos de 2 minutos.</p>
                    
                    <form method="POST" action="<?php echo esc_url( get_permalink() ?: site_url('/autenticacion/') ); ?>">
                        <?php wp_nonce_field( 'micatalogo_auth_action', 'micatalogo_auth_nonce' ); ?>
                        <input type="hidden" name="auth_action" value="register">
                        
                        <div class="form-group">
                            <label for="store_name">Nombre de tu Tienda</label>
                            <input type="text" id="store_name" name="store_name" placeholder="Ej: Aura Jewelry" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" placeholder="tu@correo.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Contraseña Segura</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        
                        <button type="submit" class="button button-primary button-block">Crear Cuenta</button>
                    </form>

                    <div class="auth-toggle">
                        ¿Ya tienes una cuenta? <a href="?action=login">Inicia Sesión</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php wp_footer(); ?>
</body>
</html>
