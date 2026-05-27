<?php
namespace MiCatalogo;

class WhatsAppOrder {
    public function __construct() {
        add_action('wp_ajax_micatalogo_whatsapp_order', [$this, 'process']);
        add_action('wp_ajax_nopriv_micatalogo_whatsapp_order', [$this, 'process']);
        add_shortcode('micatalogo_whatsapp_button', [$this, 'render_button']);
    }

    public function process() {
        // Verificar nonce
        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'micatalogo_cart_nonce' ) ) {
            wp_send_json_error( ['message' => 'Token de seguridad inválido. Recarga la página.'] );
        }

        $client_name = sanitize_text_field( $_POST['client_name'] ?? '' );
        $client_phone = sanitize_text_field( $_POST['client_phone'] ?? '' );
        $vendor_id = intval( $_POST['vendor_id'] ?? 0 );
        $cart_items_json = wp_unslash( $_POST['cart_items'] ?? '[]' );
        $cart_items = json_decode( $cart_items_json, true );

        if ( empty( $cart_items ) || ! is_array( $cart_items ) ) {
            wp_send_json_error( ['message' => 'El carrito está vacío.'] );
        }

        if ( ! $vendor_id ) {
            wp_send_json_error( ['message' => 'Vendedor no válido.'] );
        }

        // Obtener la tasa de cambio del vendedor (si la tiene) o usar un fallback
        $exchange_rate = get_user_meta( $vendor_id, 'exchange_rate', true );
        $exchange_rate = $exchange_rate ? floatval( $exchange_rate ) : 36.5; // Fallback

        // Crear el post tipo 'pedido'
        $order_id = wp_insert_post([
            'post_type' => 'pedido',
            'post_title' => 'Pedido #' . time() . ( $client_name ? ' - ' . $client_name : '' ),
            'post_status' => 'publish', 
        ]);
        
        if ( $order_id && ! is_wp_error( $order_id ) ) {
            // Guardar meta
            update_post_meta( $order_id, '_customer_name', $client_name );
            update_post_meta( $order_id, '_customer_phone', $client_phone );
            update_post_meta( $order_id, '_vendor_id', $vendor_id );
            update_post_meta( $order_id, '_cart_items', $cart_items );
            
            // Construir mensaje de WhatsApp
            $whatsapp_msg = "¡Hola! Quiero realizar un pedido:\n\n";
            $total_usd = 0;

            foreach ( $cart_items as $item ) {
                $qty = intval( $item['qty'] );
                $price = floatval( $item['price'] );
                $subtotal = $qty * $price;
                $total_usd += $subtotal;
                $whatsapp_msg .= "▪ {$qty}x " . sanitize_text_field($item['title']) . " - $" . number_format($subtotal, 2) . "\n";
            }

            $total_bs = $total_usd * $exchange_rate;
            update_post_meta( $order_id, '_order_total', $total_usd );
            
            $whatsapp_msg .= "\n*Total USD:* $" . number_format($total_usd, 2);
            $whatsapp_msg .= "\n*Total Bs:* Bs. " . number_format($total_bs, 2) . " (Tasa: {$exchange_rate})";
            $whatsapp_msg .= "\n\nPor favor, confírmame el pedido y métodos de pago. Referencia del sistema: #" . $order_id;
            
            // Obtener WhatsApp del vendedor
            $vendor_whatsapp = get_user_meta( $vendor_id, 'whatsapp_number', true );
            if ( empty( $vendor_whatsapp ) ) {
                wp_send_json_error( ['message' => 'El vendedor no tiene configurado su WhatsApp.'] );
            }
            $clean_phone = preg_replace('/[^0-9]/', '', $vendor_whatsapp);
            $whatsapp_url = 'https://wa.me/' . $clean_phone . '?text=' . urlencode( $whatsapp_msg );
            
            // Enviar notificaciones
            $this->send_notifications( $order_id, $vendor_id );
            
            wp_send_json_success(['whatsapp_url' => $whatsapp_url]);
        } else {
            wp_send_json_error(['message' => 'No se pudo crear el pedido en el servidor.']);
        }
    }
    
    private function send_notifications( $order_id, $vendor_id ) {
        $vendor_info = get_userdata( $vendor_id );
        if ( $vendor_info ) {
            wp_mail( $vendor_info->user_email, 'Nuevo pedido recibido #' . $order_id, 'Tienes un nuevo pedido pendiente. Revisa tu panel o tu WhatsApp.' );
        }
    }

    public function render_button() {
        return '<button id="checkout-btn" class="button button-primary button-block">Pedir por WhatsApp</button>';
    }
}
