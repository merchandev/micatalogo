document.addEventListener('DOMContentLoaded', () => {
    const checkoutBtn = document.getElementById('checkout-btn');
    if(!checkoutBtn) return;

    checkoutBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        
        if(!window.MiCatalogoVendor) {
            alert("Error: No se encontró la información del vendedor.");
            return;
        }

        const vendorId = window.MiCatalogoVendor.id;
        const storageKey = `micatalogo_cart_${vendorId}`;
        
        let cart = [];
        try {
            cart = JSON.parse(localStorage.getItem(storageKey)) || [];
        } catch(err) {}

        if(cart.length === 0) {
            alert("El carrito está vacío.");
            return;
        }

        const originalText = checkoutBtn.textContent;
        checkoutBtn.textContent = "Procesando...";
        checkoutBtn.disabled = true;

        const formData = new FormData();
        formData.append('action', 'micatalogo_whatsapp_order');
        formData.append('nonce', micatalogo_ajax.nonce);
        formData.append('vendor_id', vendorId);
        formData.append('cart_items', JSON.stringify(cart));
        // Opcional: Recoger el nombre/teléfono si hubiera campos en la interfaz
        formData.append('client_name', document.getElementById('client-name')?.value || '');
        formData.append('client_phone', document.getElementById('client-phone')?.value || '');

        try {
            const response = await fetch(micatalogo_ajax.ajax_url, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success && result.data.whatsapp_url) {
                // Vaciar carrito
                localStorage.removeItem(storageKey);
                // Abrir WhatsApp
                window.open(result.data.whatsapp_url, '_blank');
                // Recargar para limpiar UI
                window.location.reload();
            } else {
                alert("Error al procesar el pedido: " + (result.data?.message || "Desconocido"));
            }
        } catch (err) {
            alert("Error de conexión.");
            console.error(err);
        } finally {
            checkoutBtn.textContent = originalText;
            checkoutBtn.disabled = false;
        }
    });
});
