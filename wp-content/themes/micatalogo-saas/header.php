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
        
        <div class="header-right" style="display: flex; align-items: center; gap: 16px;">
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

            <button id="theme-toggle" aria-label="Cambiar tema" style="background: transparent; border: none; color: var(--text-main); cursor: pointer; padding: 8px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: background 0.2s;">
                <svg id="theme-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                <svg id="theme-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; display: none;"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
            </button>

            <button class="mobile-menu-toggle" aria-label="Abrir menú" style="display: none; background: transparent; border: none; color: var(--text-main); cursor: pointer; padding: 5px;">
                <span class="material-symbols-outlined" style="font-size: 2rem;">menu</span>
            </button>
        </div>
    </div>
</header>

<script>
// Theme Switcher Logic
const themeToggleBtn = document.getElementById('theme-toggle');
const iconMoon = document.getElementById('theme-icon-moon');
const iconSun = document.getElementById('theme-icon-sun');

// Initialize Theme
const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : 'dark';
if (currentTheme === 'light') {
    document.documentElement.setAttribute('data-theme', 'light');
    iconMoon.style.display = 'none';
    iconSun.style.display = 'block';
}

themeToggleBtn.addEventListener('click', function() {
    let theme = document.documentElement.getAttribute('data-theme');
    if (theme === 'light') {
        document.documentElement.removeAttribute('data-theme');
        localStorage.setItem('theme', 'dark');
        iconMoon.style.display = 'block';
        iconSun.style.display = 'none';
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
        iconMoon.style.display = 'none';
        iconSun.style.display = 'block';
    }
});

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
