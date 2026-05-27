<?php
namespace MiCatalogo;

class SaaS_Billing {
    public function __construct() {
        // Asignar plan básico al registrar nuevo vendedor
        add_action( 'user_register', [ $this, 'assign_default_plan' ] );
        // Evento diario para revisar suscripciones vencidas
        add_action( 'micatalogo_daily_billing_check', [ $this, 'check_expired_subscriptions' ] );
    }

    public function get_plans() {
        return [
            'basic'   => [ 'name' => 'Basic', 'price' => 0, 'limit' => 10, 'images_limit' => 1 ],
            'pro'     => [ 'name' => 'Pro', 'price' => 3.99, 'limit' => 200, 'images_limit' => 3 ],
            'empresa' => [ 'name' => 'Empresarial', 'price' => 9.99, 'limit' => -1, 'images_limit' => -1 ]
        ];
    }

    public function assign_default_plan( $user_id ) {
        // Solo aplicar si es vendor
        $user = get_userdata( $user_id );
        if ( in_array( 'vendor', (array) $user->roles ) ) {
            update_user_meta( $user_id, 'micatalogo_plan', 'basic' );
            update_user_meta( $user_id, 'subscription_status', 'active' );
            // Trial de 30 días para basic o simplemente activo siempre (al ser gratis)
            update_user_meta( $user_id, 'subscription_end_date', date( 'Y-m-d', strtotime( '+10 years' ) ) );
        }
    }

    public function is_subscription_active( $vendor_id ) {
        $status = get_user_meta( $vendor_id, 'subscription_status', true );
        $end_date = get_user_meta( $vendor_id, 'subscription_end_date', true );
        
        if ( $status !== 'active' ) {
            return false;
        }

        if ( ! empty( $end_date ) && strtotime( $end_date ) < time() ) {
            $this->deactivate_subscription( $vendor_id );
            return false;
        }

        return true;
    }

    public function deactivate_subscription( $vendor_id ) {
        update_user_meta( $vendor_id, 'subscription_status', 'expired' );
        
        // Cambiar productos a draft
        $args = [
            'post_type' => 'micatalogo_product',
            'author'    => $vendor_id,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids'
        ];
        
        $products = get_posts( $args );
        foreach ( $products as $product_id ) {
            wp_update_post( [
                'ID' => $product_id,
                'post_status' => 'draft'
            ] );
        }
    }

    public function check_expired_subscriptions() {
        $vendors = get_users( [ 'role' => 'vendor' ] );
        foreach ( $vendors as $vendor ) {
            $this->is_subscription_active( $vendor->ID );
        }
    }
}
