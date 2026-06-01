<?php
/**
 * Template Name: Panel de Vendedor
 */

if ( ! is_user_logged_in() ) {
    wp_redirect( site_url( '/autenticacion/' ) );
    exit;
}

$user = wp_get_current_user();
$store_name = get_user_meta( $user->ID, 'store_name', true ) ?: 'Mi Tienda';
$whatsapp = get_user_meta( $user->ID, 'whatsapp_number', true );

// Update Appearance if submitted
if ( isset($_POST['update_appearance']) ) {
    $store_template = sanitize_text_field($_POST['store_template']);
    update_user_meta($user->ID, 'store_template', $store_template);
}

// Instanciamos temporalmente la clase para stats
$dashboard = new \MiCatalogo\Vendor_Dashboard();
$stats = $dashboard->get_stats( $user->ID );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - <?php echo esc_html( $store_name ); ?></title>
    <?php wp_head(); ?>
    <style>
        .panel-section { animation: fadeIn 0.3s ease forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="dashboard-page">

    <div class="dashboard-layout">
        
        <!-- Sidebar Fijo -->
        <aside class="dashboard-sidebar">
            <div class="sidebar-header">
                <h2><?php echo esc_html( $store_name ); ?></h2>
                <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: var(--primary);">Plan Pro</span>
            </div>
            
            <nav class="sidebar-nav">
                <a href="#resumen" class="active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    Resumen
                </a>
                <a href="#productos">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 16.2A2 2 0 0 0 21.2 14.5L21.2 9.5A2 2 0 0 0 20 7.8L13 3.8A2 2 0 0 0 11 3.8L4 7.8A2 2 0 0 0 2.8 9.5L2.8 14.5A2 2 0 0 0 4 16.2L11 20.2A2 2 0 0 0 13 20.2L20 16.2Z"></path><polyline points="3.2 8.7 12 13.7 20.8 8.7"></polyline><line x1="12" y1="22.2" x2="12" y2="13.7"></line></svg>
                    Productos
                </a>
                <a href="#apariencia">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path></svg>
                    Apariencia
                </a>
                <a href="#configuracion">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    Ajustes
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <a href="<?php echo wp_logout_url( site_url() ); ?>" class="logout-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Cerrar Sesión
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="dashboard-main">
            <header class="dashboard-header reveal-fade">
                <div class="header-search">
                    <input type="text" placeholder="Buscar productos, pedidos...">
                </div>
                <div class="header-actions">
                    <a href="<?php echo site_url('/tienda/' . $user->user_login); ?>" target="_blank" class="button button-outline" style="padding: 8px 16px; font-size: 0.9rem;">Ver mi tienda</a>
                </div>
            </header>

            <div class="dashboard-content">
                
                <!-- SECCION RESUMEN -->
                <div id="section-resumen" class="panel-section active">
                    <h1 class="reveal-up">Resumen General</h1>
                    <div class="stats-grid">
                        <div class="stat-card glass-card reveal-up delay-100">
                            <div class="stat-icon" style="color: #3B82F6; background: rgba(59, 130, 246, 0.1);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 12h4l2-9 5 18 3-10h6"></path></svg>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Visitas Totales</span>
                                <span class="stat-value"><?php echo $stats['views_today']; ?></span>
                            </div>
                        </div>
                        <div class="stat-card glass-card reveal-up delay-200">
                            <div class="stat-icon" style="color: #10B981; background: rgba(16, 185, 129, 0.1);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Clics a WhatsApp (Mes)</span>
                                <span class="stat-value"><?php echo $stats['orders_month']; ?></span>
                            </div>
                        </div>
                        <div class="stat-card glass-card reveal-up delay-300">
                            <div class="stat-icon" style="color: #F59E0B; background: rgba(245, 158, 11, 0.1);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 16.2A2 2 0 0 0 21.2 14.5L21.2 9.5A2 2 0 0 0 20 7.8L13 3.8A2 2 0 0 0 11 3.8L4 7.8A2 2 0 0 0 2.8 9.5L2.8 14.5A2 2 0 0 0 4 16.2L11 20.2A2 2 0 0 0 13 20.2L20 16.2Z"></path></svg>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Productos Activos</span>
                                <span class="stat-value"><?php echo $stats['products_active']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCION PRODUCTOS -->
                <div id="section-productos" class="panel-section" style="display:none;">
                    <div class="dashboard-panel glass-card reveal-up" style="margin-top: 0;">
                        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                            <h3 style="margin:0;">Mis Productos</h3>
                            <button class="button button-primary" onclick="document.getElementById('modal-nuevo-producto').style.display='flex'" style="padding: 8px 16px;">+ Nuevo Producto</button>
                        </div>
                        
                        <?php
                        $products = $dashboard->get_vendor_products( $user->ID );
                        if ( empty( $products ) ) : ?>
                            <div class="empty-state text-center" style="padding: 60px 0;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" style="width: 48px; height: 48px; margin-bottom: 16px;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                <h4 style="margin-bottom: 8px;">Aún no tienes productos</h4>
                                <p style="color: var(--text-muted); max-width: 400px; margin: 0 auto;">Crea tu primer producto para que tus clientes puedan empezar a hacer pedidos.</p>
                            </div>
                        <?php else : ?>
                            <div class="products-table-wrapper" style="overflow-x: auto;">
                                <table class="products-table" style="width: 100%; border-collapse: collapse; text-align: left;">
                                    <thead>
                                        <tr style="border-bottom: 1px solid var(--border); color: var(--text-muted);">
                                            <th style="padding: 12px;">Producto</th>
                                            <th style="padding: 12px;">Precio</th>
                                            <th style="padding: 12px; text-align: right;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ( $products as $p ) : 
                                            $price = get_post_meta( $p->ID, '_price', true );
                                            $thumb = get_the_post_thumbnail_url( $p->ID, 'thumbnail' );
                                        ?>
                                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                            <td style="padding: 16px 12px; display: flex; align-items: center; gap: 16px;">
                                                <?php if($thumb): ?>
                                                    <img src="<?php echo esc_url($thumb); ?>" style="width:48px; height:48px; object-fit:cover; border-radius:8px;">
                                                <?php else: ?>
                                                    <div style="width:48px; height:48px; background:var(--border); border-radius:8px;"></div>
                                                <?php endif; ?>
                                                <strong style="color:#fff;"><?php echo esc_html($p->post_title); ?></strong>
                                            </td>
                                            <td style="padding: 16px 12px;">$<?php echo number_format((float)$price, 2); ?></td>
                                            <td style="padding: 16px 12px; text-align: right;">
                                                <form method="POST" action="" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                                                    <?php wp_nonce_field( 'micatalogo_save_product', 'micatalogo_product_nonce' ); ?>
                                                    <input type="hidden" name="micatalogo_product_action" value="delete">
                                                    <input type="hidden" name="product_id" value="<?php echo $p->ID; ?>">
                                                    <button type="submit" style="background:none; border:none; color:#EF4444; cursor:pointer; font-weight:600;">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- SECCION APARIENCIA -->
                <div id="section-apariencia" class="panel-section" style="display:none;">
                    <h1 class="reveal-up">Apariencia</h1>
                    <div class="dashboard-panel glass-card reveal-up" style="margin-top: 24px;">
                        <h3>Personaliza tu Tienda</h3>
                        <p style="color:var(--text-muted)">Aquí podrás elegir y cambiar la plantilla de tu tienda.</p>
                        <form method="POST" action="#apariencia">
                            <input type="hidden" name="update_appearance" value="1">
                            <div class="form-group" style="margin-top: 20px;">
                                <label style="display:block; margin-bottom:8px; font-weight:500;">Planilla Seleccionada</label>
                                <select name="store_template" style="width:100%; max-width:400px; padding:12px; background:var(--bg-dark); border:1px solid var(--border); color:#fff; border-radius:8px; margin-bottom:16px;">
                                    <?php $current_tpl = get_user_meta($user->ID, 'store_template', true); ?>
                                    <option value="moderna" <?php selected($current_tpl, 'moderna'); ?>>Moderna</option>
                                    <option value="elegante" <?php selected($current_tpl, 'elegante'); ?>>Elegante</option>
                                    <option value="minimalista" <?php selected($current_tpl, 'minimalista'); ?>>Minimalista</option>
                                </select>
                            </div>
                            <button type="submit" class="button button-primary">Guardar Apariencia</button>
                        </form>
                    </div>
                </div>

                <!-- SECCION CONFIGURACION -->
                <div id="section-configuracion" class="panel-section" style="display:none;">
                    <h1 class="reveal-up">Ajustes Generales</h1>
                    <div class="dashboard-panel glass-card reveal-up" style="margin-top: 24px;">
                        <form method="POST" action="#configuracion">
                            <?php wp_nonce_field( 'micatalogo_save_product', 'micatalogo_product_nonce' ); ?>
                            <input type="hidden" name="micatalogo_product_action" value="update_settings">
                            
                            <div class="form-group" style="margin-bottom:16px;">
                                <label style="display:block; margin-bottom:8px; font-weight:500;">Número de WhatsApp (Ventas)</label>
                                <input type="text" name="whatsapp_number" value="<?php echo esc_attr($whatsapp); ?>" style="width:100%; max-width:400px; padding:12px; background:var(--bg-dark); border:1px solid var(--border); color:#fff; border-radius:8px;">
                                <small style="display:block; color:var(--text-muted); margin-top:8px;">Los pedidos llegarán a este número.</small>
                            </div>

                            <button type="submit" class="button button-primary" style="margin-top:16px;">Guardar Ajustes</button>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Modal Nuevo Producto -->
    <div id="modal-nuevo-producto" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:999; justify-content:center; align-items:center; backdrop-filter:blur(4px);">
        <div class="glass-card" style="width:100%; max-width:500px; padding:32px; border-radius:16px; position:relative;">
            <button onclick="document.getElementById('modal-nuevo-producto').style.display='none'" style="position:absolute; top:20px; right:20px; background:none; border:none; color:#fff; cursor:pointer; font-size:1.5rem;">&times;</button>
            <h2 style="margin-top:0; margin-bottom:24px;">Añadir Producto</h2>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <?php wp_nonce_field( 'micatalogo_save_product', 'micatalogo_product_nonce' ); ?>
                <input type="hidden" name="micatalogo_product_action" value="create">
                
                <div class="form-group" style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:8px;">Nombre del Producto</label>
                    <input type="text" name="product_title" required style="width:100%; padding:12px; background:var(--bg-dark); border:1px solid var(--border); color:#fff; border-radius:8px;">
                </div>
                
                <div class="form-group" style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:8px;">Precio</label>
                    <input type="number" step="0.01" name="product_price" required style="width:100%; padding:12px; background:var(--bg-dark); border:1px solid var(--border); color:#fff; border-radius:8px;">
                </div>

                <div class="form-group" style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:8px;">Descripción Breve</label>
                    <textarea name="product_desc" rows="3" style="width:100%; padding:12px; background:var(--bg-dark); border:1px solid var(--border); color:#fff; border-radius:8px;"></textarea>
                </div>

                <div class="form-group" style="margin-bottom:24px;">
                    <label style="display:block; margin-bottom:8px;">Imagen Principal</label>
                    <input type="file" name="product_image" accept="image/*" style="width:100%; padding:12px; background:var(--bg-dark); border:1px dashed var(--primary); color:#fff; border-radius:8px;">
                </div>

                <button type="submit" class="button button-primary button-block">Guardar Producto</button>
            </form>
        </div>
    </div>

    <?php wp_footer(); ?>
    <script>
        // Navegación de Pestañas
        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            link.addEventListener('click', function(e) {
                if(this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    
                    // Actualizar link activo
                    document.querySelectorAll('.sidebar-nav a').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Ocultar todas las secciones
                    document.querySelectorAll('.panel-section').forEach(sec => sec.style.display = 'none');
                    
                    // Mostrar sección destino
                    const targetId = 'section-' + this.getAttribute('href').substring(1);
                    const target = document.getElementById(targetId);
                    if(target) {
                        target.style.display = 'block';
                    }
                    
                    // Actualizar URL sin recargar
                    window.history.pushState(null, null, this.getAttribute('href'));
                }
            });
        });

        // Revisar hash al cargar la página
        window.addEventListener('load', () => {
            if(window.location.hash) {
                const link = document.querySelector('.sidebar-nav a[href="' + window.location.hash + '"]');
                if(link) {
                    // Solo ejecutar la logica visual, no redirigir
                    document.querySelectorAll('.sidebar-nav a').forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                    
                    document.querySelectorAll('.panel-section').forEach(sec => sec.style.display = 'none');
                    const targetId = 'section-' + window.location.hash.substring(1);
                    const target = document.getElementById(targetId);
                    if(target) target.style.display = 'block';
                }
            }
        });
    </script>
</body>
</html>
