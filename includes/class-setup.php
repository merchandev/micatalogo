<?php
namespace MiCatalogo;

class Setup {
    public function __construct() {
        add_action( 'after_switch_theme', [ $this, 'install_default_pages' ] );
        add_action( 'after_switch_theme', [ $this, 'setup_menus' ] );
    }

    public function install_default_pages() {
        $pages = [
            'Inicio'                 => 'page-templates/page-inicio.php',
            'Planes'                 => 'page-templates/page-planes.php',
            'Demo'                   => '',
            'Tutoriales'             => 'page-templates/page-tutoriales.php',
            'Términos y condiciones' => 'page-templates/page-legal.php',
            'Política de privacidad' => 'page-templates/page-legal.php',
            'Cookies'                => 'page-templates/page-legal.php',
            'Casos de éxito'         => '',
            'Contacto'               => 'page-templates/page-contacto.php',
            'Blog'                   => '',
            'Autenticacion'          => 'page-templates/page-auth.php',
            'Onboarding'             => 'page-templates/page-onboarding.php',
            'Panel Vendedor'         => 'page-templates/page-panel.php',
        ];

        $front_page_id = 0;
        $blog_page_id = 0;

        foreach ( $pages as $title => $template ) {
            $query = new \WP_Query([
                'post_type'              => 'page',
                'title'                  => $title,
                'post_status'            => 'all',
                'posts_per_page'         => 1,
                'no_found_rows'          => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            ]);
            $page_check = ! empty( $query->posts ) ? $query->posts[0] : null;
            
            if ( ! isset( $page_check->ID ) ) {
                $new_page_id = wp_insert_post( [
                    'post_type'    => 'page',
                    'post_title'   => $title,
                    'post_content' => '',
                    'post_status'  => 'publish',
                    'post_author'  => 1,
                ] );

                if ( ! is_wp_error( $new_page_id ) && ! empty( $template ) ) {
                    update_post_meta( $new_page_id, '_wp_page_template', $template );
                }

                if ( $title === 'Inicio' && ! is_wp_error( $new_page_id ) ) {
                    $front_page_id = $new_page_id;
                }
                if ( $title === 'Blog' && ! is_wp_error( $new_page_id ) ) {
                    $blog_page_id = $new_page_id;
                }
            } else {
                if ( $title === 'Inicio' ) {
                    $front_page_id = $page_check->ID;
                }
                if ( $title === 'Blog' ) {
                    $blog_page_id = $page_check->ID;
                }
            }
        }

        // Configurar portada estática
        if ( $front_page_id > 0 ) {
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $front_page_id );
        }
        
        // Configurar página de entradas
        if ( $blog_page_id > 0 ) {
            update_option( 'page_for_posts', $blog_page_id );
        }
    }

    public function setup_menus() {
        $menu_name = 'Menú Principal SaaS';
        $menu_exists = wp_get_nav_menu_object( $menu_name );

        if ( ! $menu_exists ) {
            $menu_id = wp_create_nav_menu( $menu_name );

            // Añadir enlaces básicos al menú
            $pages_to_add = [ 'Inicio', 'Planes', 'Tutoriales', 'Contacto' ];
            foreach ( $pages_to_add as $page_title ) {
                $query = new \WP_Query([
                    'post_type'              => 'page',
                    'title'                  => $page_title,
                    'post_status'            => 'all',
                    'posts_per_page'         => 1,
                    'no_found_rows'          => true,
                    'update_post_term_cache' => false,
                    'update_post_meta_cache' => false,
                ]);
                $page = ! empty( $query->posts ) ? $query->posts[0] : null;

                if ( $page ) {
                    wp_update_nav_menu_item( $menu_id, 0, [
                        'menu-item-title'     => $page->post_title,
                        'menu-item-object-id' => $page->ID,
                        'menu-item-object'    => 'page',
                        'menu-item-status'    => 'publish',
                        'menu-item-type'      => 'post_type',
                    ] );
                }
            }

            // Asignar el menú a la ubicación del tema
            $locations = get_theme_mod( 'nav_menu_locations' );
            $locations['menu-principal'] = $menu_id;
            set_theme_mod( 'nav_menu_locations', $locations );
        }
    }
}
