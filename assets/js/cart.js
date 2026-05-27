document.addEventListener('DOMContentLoaded', () => {
    
    // Solo inicializar si hay carrito
    const floatingCart = document.getElementById('floating-cart');
    const cartModal = document.getElementById('cart-modal');
    if(!floatingCart) return;

    let cart = [];
    const vendorId = window.MiCatalogoVendor ? window.MiCatalogoVendor.id : 'default';
    const storageKey = `micatalogo_cart_${vendorId}`;

    // Cargar carrito
    try {
        const saved = localStorage.getItem(storageKey);
        if(saved) cart = JSON.parse(saved);
    } catch(e) {}

    const saveCart = () => {
        localStorage.setItem(storageKey, JSON.stringify(cart));
        updateCartUI();
    };

    const updateCartUI = () => {
        const countEl = document.getElementById('cart-count');
        const totalEl = document.getElementById('cart-total');
        const modalTotalEl = document.getElementById('cart-modal-total');
        const container = document.getElementById('cart-items-container');
        
        let count = 0;
        let total = 0;

        container.innerHTML = '';

        cart.forEach((item, index) => {
            count += item.qty;
            total += (item.price * item.qty);

            // Render modal item
            container.innerHTML += `
                <div style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.05); padding:16px; border-radius:8px;">
                    <div>
                        <div style="font-weight:600; margin-bottom:4px;">${item.title}</div>
                        <div style="color:var(--primary);">$${item.price.toFixed(2)}</div>
                    </div>
                    <div style="display:flex; align-items:center; gap:12px;">
                        <button class="btn-qty" onclick="updateQty(${index}, -1)" style="background:var(--border); border:none; color:#fff; width:28px; height:28px; border-radius:4px; cursor:pointer;">-</button>
                        <span>${item.qty}</span>
                        <button class="btn-qty" onclick="updateQty(${index}, 1)" style="background:var(--border); border:none; color:#fff; width:28px; height:28px; border-radius:4px; cursor:pointer;">+</button>
                    </div>
                </div>
            `;
        });

        if(count > 0) {
            floatingCart.style.display = 'flex';
        } else {
            floatingCart.style.display = 'none';
            container.innerHTML = '<p style="text-align:center; color:var(--text-muted); margin-top:40px;">Tu pedido está vacío.</p>';
        }

        countEl.textContent = count;
        totalEl.textContent = `$${total.toFixed(2)}`;
        modalTotalEl.textContent = `$${total.toFixed(2)}`;
    };

    // Añadir al carrito
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault(); // Por si es un enlace
            const id = btn.getAttribute('data-id');
            const title = btn.getAttribute('data-title');
            const price = parseFloat(btn.getAttribute('data-price'));

            const existing = cart.find(i => i.id === id);
            if(existing) {
                existing.qty += 1;
            } else {
                cart.push({ id, title, price, qty: 1 });
            }

            // Animación visual del botón
            const originalText = btn.textContent;
            btn.textContent = "¡Añadido!";
            btn.style.background = "var(--primary)";
            btn.style.color = "#000";
            setTimeout(() => {
                btn.textContent = originalText;
                btn.style.background = "";
                btn.style.color = "";
            }, 1000);

            saveCart();
        });
    });

    window.updateQty = (index, delta) => {
        cart[index].qty += delta;
        if(cart[index].qty <= 0) {
            cart.splice(index, 1);
        }
        saveCart();
    };

    floatingCart.addEventListener('click', () => {
        cartModal.style.display = 'flex';
    });

    updateCartUI(); // Init
});
