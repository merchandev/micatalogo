<?php
/**
 * Header genérico del tema
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="site-header">
    <div class="container header-container">
        <div class="site-branding">
            <?php
            if ( has_custom_logo() ) {
                the_custom_logo();
            } else {
                echo '<h1><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a></h1>';
            }
            ?>
        </div>
        
        <button class="mobile-menu-toggle" aria-label="Abrir menú" style="display: none; background: transparent; border: none; color: var(--text-main); cursor: pointer; padding: 5px;">
            <span class="material-symbols-outlined" style="font-size: 2rem;">menu</span>
        </button>

        <nav id="site-navigation" class="main-navigation">
            <?php
            if ( has_nav_menu( 'menu-principal' ) ) {
                wp_nav_menu( [
                    'theme_location' => 'menu-principal',
                    'menu_id'        => 'primary-menu',
                ] );
            } else {
                // Fallback Menu
                ?>
                <ul id="primary-menu" class="menu" style="display: flex; list-style: none; gap: 30px; align-items: center; margin: 0; padding: 0;">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: var(--text-main); text-decoration: none; font-weight: 500;">Inicio</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/demos/' ) ); ?>" style="color: var(--text-main); text-decoration: none; font-weight: 500;">Demos</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/planes/' ) ); ?>" style="color: var(--text-main); text-decoration: none; font-weight: 500;">Planes</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/funcionalidades/' ) ); ?>" style="color: var(--text-main); text-decoration: none; font-weight: 500;">Funcionalidades</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>" style="color: var(--text-main); text-decoration: none; font-weight: 500;">Contacto</a></li>
                    <li style="margin-left: 20px;"><a href="<?php echo esc_url( home_url( '/autenticacion/' ) ); ?>" style="color: var(--text-muted); text-decoration: none; font-weight: 500;">Ingresar</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/autenticacion/?action=register' ) ); ?>" class="button button-primary" style="padding: 10px 24px; font-size: 0.95rem; border-radius: 8px; text-decoration: none; font-weight: 600;">Crear tienda</a></li>
                </ul>
                <?php
            }
            ?>
        </nav>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.querySelector('.mobile-menu-toggle');
    const nav = document.querySelector('.main-navigation');
    const icon = toggle ? toggle.querySelector('.material-symbols-outlined') : null;
    
    if (toggle && nav && icon) {
        toggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            if (nav.classList.contains('active')) {
                icon.textContent = 'close';
            } else {
                icon.textContent = 'menu';
            }
        });
    }
});
</script>
