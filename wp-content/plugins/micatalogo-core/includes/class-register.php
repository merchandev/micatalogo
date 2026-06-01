<?php
namespace MiCatalogo;

class Register {
    public function __construct() {
        add_shortcode( 'micatalogo_register', [ $this, 'render_register_form' ] );
        add_action( 'wp_ajax_nopriv_micatalogo_register_vendor', [ $this, 'handle_registration' ] );
    }

    public function render_register_form() {
        ob_start();
        ?>
        <div id="micatalogo-register-app" class="register-container" style="max-width: 500px; margin: 0 auto; background: var(--bg-card); padding: 40px; border-radius: 12px; border: 1px solid var(--border);">
            <h2 style="text-align: center; margin-bottom: 24px;">Crea tu Tienda</h2>
            <form id="micatalogo-register-form">
                <?php wp_nonce_field( 'micatalogo_register_nonce', 'security' ); ?>
                
                <div class="form-group">
                    <label>Plan seleccionado</label>
                    <select name="plan_id" required style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--border); border-radius: 8px;">
                        <option value="basic">Basic (Gratis)</option>
                        <option value="pro">Pro ($3.99/mes)</option>
                        <option value="empresa">Empresarial ($9.99/mes)</option>
                    </select>
                </div>

                <div class="form-group" style="margin-top: 16px;">
                    <label>Nombre de la Tienda</label>
                    <input type="text" name="store_name" required placeholder="Ej: Moda Venezuela" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--border); border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-top: 16px;">
                    <label>Correo Electrónico</label>
                    <input type="email" name="user_email" required placeholder="tu@correo.com" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--border); border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-top: 16px; margin-bottom: 24px;">
                    <label>Contraseña</label>
                    <input type="password" name="user_password" required placeholder="Min. 8 caracteres" minlength="8" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--border); border-radius: 8px;">
                </div>

                <button type="submit" class="button button-primary button-block">Registrarme y Crear Tienda</button>
                <div id="register-message" style="margin-top: 16px; text-align: center; display: none;"></div>
            </form>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('micatalogo-register-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const btn = form.querySelector('button[type="submit"]');
                    const msg = document.getElementById('register-message');
                    btn.disabled = true;
                    btn.textContent = 'Procesando...';
                    
                    const formData = new FormData(form);
                    formData.append('action', 'micatalogo_register_vendor');
                    
                    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(response => {
                        msg.style.display = 'block';
                        if (response.success) {
                            msg.style.color = '#10B981';
                            msg.textContent = '¡Registro exitoso! Redirigiendo...';
                            setTimeout(() => {
                                window.location.href = response.data.redirect;
                            }, 1500);
                        } else {
                            msg.style.color = '#EF4444';
                            msg.textContent = response.data.message || 'Ocurrió un error.';
                            btn.disabled = false;
                            btn.textContent = 'Registrarme y Crear Tienda';
                        }
                    })
                    .catch(() => {
                        msg.style.display = 'block';
                        msg.style.color = '#EF4444';
                        msg.textContent = 'Error de conexión.';
                        btn.disabled = false;
                        btn.textContent = 'Registrarme y Crear Tienda';
                    });
                });
            }
        });
        </script>
        <?php
        return ob_get_clean();
    }

    public function handle_registration() {
        check_ajax_referer( 'micatalogo_register_nonce', 'security' );

        $email = sanitize_email( $_POST['user_email'] ?? '' );
        $password = $_POST['user_password'] ?? '';
        $store_name = sanitize_text_field( $_POST['store_name'] ?? '' );
        $plan_id = sanitize_text_field( $_POST['plan_id'] ?? 'basic' );

        if ( empty( $email ) || empty( $password ) || empty( $store_name ) ) {
            wp_send_json_error( ['message' => 'Todos los campos son obligatorios.'] );
        }

        if ( email_exists( $email ) ) {
            wp_send_json_error( ['message' => 'Este correo ya está registrado.'] );
        }

        // Crear nombre de usuario a partir del email
        $username = sanitize_user( current( explode( '@', $email ) ), true );
        if ( username_exists( $username ) ) {
            $username .= '_' . rand( 1000, 9999 );
        }

        $user_id = wp_create_user( $username, $password, $email );

        if ( is_wp_error( $user_id ) ) {
            wp_send_json_error( ['message' => $user_id->get_error_message()] );
        }

        // Asignar rol vendor (esto también activará el assign_default_plan de SaaS_Billing)
        $user = new \WP_User( $user_id );
        $user->set_role( 'vendor' );

        // Actualizar datos
        update_user_meta( $user_id, 'micatalogo_store_name', $store_name );
        update_user_meta( $user_id, 'micatalogo_plan', $plan_id );

        // Loguear automáticamente
        wp_set_current_user( $user_id );
        wp_set_auth_cookie( $user_id, true );

        wp_send_json_success( [
            'message' => 'Registro exitoso.',
            'redirect' => home_url( '/onboarding/' ) // Redirige al setup
        ] );
    }
}
