<?php
namespace MiCatalogo;

class Auth {
    public function __construct() {
        // Redirigir wp-login.php a nuestra página (solo GET, nunca interceptar POSTs)
        add_action( 'login_init', [ $this, 'redirect_login_page' ] );
        
        // Filtros para cambiar las URLs generadas por WP
        add_filter( 'login_url', [ $this, 'custom_login_url' ], 10, 3 );
        add_filter( 'register_url', [ $this, 'custom_register_url' ] );

        // Procesar envíos de formularios en init
        add_action( 'init', [ $this, 'process_auth_forms' ] );
    }

    public function redirect_login_page() {
        // IMPORTANTE: No redirigir si es un POST, para no invalidar nonces
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            return;
        }

        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'login';
        
        // Permitir acciones como logout, recuperar contraseña, etc.
        if ( ! in_array( $action, [ 'logout', 'postpass', 'rp', 'resetpass' ] ) ) {
            wp_redirect( site_url( '/autenticacion/' ) );
            exit;
        }
    }

    public function custom_login_url( $login_url, $redirect, $force_reauth ) {
        return site_url( '/autenticacion/' );
    }

    public function custom_register_url( $register_url ) {
        return site_url( '/autenticacion/?action=register' );
    }

    public function process_auth_forms() {
        // Si no estamos enviando nuestro formulario, salimos
        if ( $_SERVER['REQUEST_METHOD'] !== 'POST' || ! isset( $_POST['micatalogo_auth_nonce'] ) ) {
            return;
        }

        // Verificar nonce — si falla, redirigir con error en lugar de wp_die
        if ( ! wp_verify_nonce( $_POST['micatalogo_auth_nonce'], 'micatalogo_auth_action' ) ) {
            $action_param = isset( $_POST['auth_action'] ) && $_POST['auth_action'] === 'register' ? '?action=register&error=nonce_failed' : '?error=nonce_failed';
            wp_redirect( site_url( '/autenticacion/' . $action_param ) );
            exit;
        }

        $action = sanitize_text_field( $_POST['auth_action'] );

        if ( $action === 'login' ) {
            $this->process_login();
        } elseif ( $action === 'register' ) {
            $this->process_register();
        }
    }

    private function process_login() {
        $email = sanitize_email( $_POST['email'] );
        $password = $_POST['password'];

        // WordPress wp_signon necesita el user_login, no el email.
        // Buscamos el usuario por email primero.
        $user_obj = get_user_by( 'email', $email );
        $user_login = $user_obj ? $user_obj->user_login : $email;

        $creds = array(
            'user_login'    => $user_login,
            'user_password' => $password,
            'remember'      => isset( $_POST['remember'] )
        );

        $user = wp_signon( $creds, is_ssl() );

        if ( is_wp_error( $user ) ) {
            wp_redirect( site_url( '/autenticacion/?error=login_failed' ) );
            exit;
        }

        // Login exitoso, redirigir al panel
        wp_redirect( site_url( '/panel-vendedor/' ) );
        exit;
    }

    private function process_register() {
        $email     = sanitize_email( $_POST['email'] );
        $password  = $_POST['password'];
        $store_name = sanitize_text_field( $_POST['store_name'] );

        if ( empty( $email ) || empty( $password ) || empty( $store_name ) ) {
            wp_redirect( site_url( '/autenticacion/?action=register&error=empty_fields' ) );
            exit;
        }

        if ( email_exists( $email ) ) {
            wp_redirect( site_url( '/autenticacion/?action=register&error=email_exists' ) );
            exit;
        }

        // Generar username único basado en el email
        $username = sanitize_user( current( explode( '@', $email ) ), true );
        if ( username_exists( $username ) ) {
            $username = $username . '_' . rand( 1000, 9999 );
        }

        $user_id = wp_insert_user( array(
            'user_login' => $username,
            'user_pass'  => $password,
            'user_email' => $email,
            'role'       => 'vendor',
        ) );

        if ( is_wp_error( $user_id ) ) {
            wp_redirect( site_url( '/autenticacion/?action=register&error=creation_failed' ) );
            exit;
        }

        // Guardar metadatos de la tienda
        update_user_meta( $user_id, 'store_name', $store_name );
        update_user_meta( $user_id, 'micatalogo_store_name', $store_name );
        update_user_meta( $user_id, 'micatalogo_plan', 'basic' );

        // Auto-login al registrar
        wp_set_current_user( $user_id );
        wp_set_auth_cookie( $user_id, true, is_ssl() );

        // Redirigir al panel del vendedor
        wp_redirect( site_url( '/panel-vendedor/' ) );
        exit;
    }
}
