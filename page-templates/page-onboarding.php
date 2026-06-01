<?php
/**
 * Template Name: Onboarding SaaS
 */

if ( ! is_user_logged_in() ) {
    wp_redirect( site_url( '/autenticacion/' ) );
    exit;
}

$user = wp_get_current_user();
$store_name = get_user_meta( $user->ID, 'store_name', true );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración Inicial - <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
    <style>
        body.onboarding-page { background-color: var(--bg-dark); color: var(--text-main); display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px; }
        .onboarding-container { max-width: 700px; width: 100%; }
        .onboarding-card { padding: 48px; border-radius: 24px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); backdrop-filter: blur(10px); }
        
        .progress-steps { display: flex; justify-content: space-between; margin-bottom: 40px; position: relative; }
        .progress-steps::before { content: ''; position: absolute; top: 50%; left: 0; width: 100%; height: 2px; background: rgba(255,255,255,0.1); z-index: 0; transform: translateY(-50%); }
        .step-indicator { width: 36px; height: 36px; border-radius: 50%; background: var(--bg-dark); border: 2px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; z-index: 1; font-weight: bold; color: rgba(255,255,255,0.5); transition: all 0.3s ease; }
        .step-indicator.active { border-color: var(--primary); color: var(--primary); box-shadow: 0 0 15px rgba(16, 185, 129, 0.3); }
        .step-indicator.completed { background: var(--primary); border-color: var(--primary); color: #fff; }

        .step-content { display: none; text-align: center; animation: fadeIn 0.4s ease forwards; }
        .step-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        h1 { font-size: 2.2rem; margin-bottom: 12px; }
        p.subtitle { color: var(--text-muted); margin-bottom: 32px; font-size: 1.1rem; }
        
        .form-group { text-align: left; margin-bottom: 24px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
        .form-group input[type="text"], .form-group input[type="number"], .form-group textarea { width: 100%; padding: 14px; background: rgba(0,0,0,0.2); border: 1px solid var(--border); border-radius: 8px; color: #fff; transition: all 0.3s ease; }
        .form-group input:focus, .form-group textarea:focus { border-color: var(--primary); outline: none; }
        
        .file-upload-wrapper { position: relative; width: 100%; border: 2px dashed var(--border); border-radius: var(--radius); padding: 32px; text-align: center; cursor: pointer; transition: var(--transition); }
        .file-upload-wrapper:hover { border-color: var(--primary); background: rgba(16, 185, 129, 0.05); }
        .file-upload-wrapper input[type="file"] { position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; }
        
        /* Templates Grid */
        .templates-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; text-align: left; margin-bottom: 24px; }
        .template-card { border: 2px solid var(--border); border-radius: 12px; padding: 16px; cursor: pointer; transition: all 0.3s ease; position: relative; overflow: hidden; background: rgba(0,0,0,0.2); }
        .template-card:hover { border-color: rgba(255,255,255,0.4); transform: translateY(-2px); }
        .template-card.selected { border-color: var(--primary); background: rgba(16, 185, 129, 0.05); box-shadow: 0 4px 20px rgba(16, 185, 129, 0.15); }
        .template-card.selected::after { content: '✓'; position: absolute; top: 12px; right: 12px; background: var(--primary); color: #fff; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold; }
        .template-card img { width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 12px; background: #222; }
        .template-card h4 { margin: 0 0 4px 0; font-size: 1.1rem; }
        .template-card p { margin: 0; font-size: 0.85rem; color: var(--text-muted); }
        
        .step-actions { display: flex; justify-content: space-between; margin-top: 40px; gap: 16px; }
        .btn-prev { background: rgba(255,255,255,0.1); color: #fff; padding: 14px 24px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; transition: all 0.3s; }
        .btn-prev:hover { background: rgba(255,255,255,0.15); }
        .btn-next { flex: 1; padding: 14px 24px; }
    </style>
</head>
<body class="onboarding-page">

    <div class="onboarding-container">
        <div class="onboarding-card">
            
            <div class="progress-steps">
                <div class="step-indicator active" id="indicator-1">1</div>
                <div class="step-indicator" id="indicator-2">2</div>
                <div class="step-indicator" id="indicator-3">3</div>
            </div>

            <form method="POST" action="" enctype="multipart/form-data" id="onboarding-form">
                <?php wp_nonce_field( 'micatalogo_onboarding_action', 'micatalogo_onboarding_nonce' ); ?>
                
                <!-- PASO 1: CONTACTO -->
                <div class="step-content active" id="step-1">
                    <h1 class="text-gradient">¡Hola, <?php echo esc_html( $store_name ?: 'Vendedor' ); ?>!</h1>
                    <p class="subtitle">Empecemos configurando cómo te contactarán tus clientes.</p>
                    
                    <div class="form-group">
                        <label for="whatsapp">Número de WhatsApp (Ventas)</label>
                        <input type="text" id="whatsapp" name="whatsapp" placeholder="Ej: +52 1 555 123 4567" required>
                        <small style="color:var(--text-muted); margin-top:8px; display:block;">Aquí es donde tus clientes te enviarán los pedidos.</small>
                    </div>

                    <div class="form-group">
                        <label>Logo de tu Tienda (Opcional por ahora)</label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="store_logo" accept="image/*" id="logo-input">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" style="margin-bottom:16px;">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            <p id="logo-text" style="margin:0; color:var(--text-main);">Haz clic o arrastra tu logo aquí</p>
                        </div>
                    </div>
                    
                    <div class="step-actions" style="justify-content: flex-end;">
                        <button type="button" class="button button-primary btn-next" onclick="nextStep(2)">Continuar al Diseño</button>
                    </div>
                </div>

                <!-- PASO 2: DISEÑO -->
                <div class="step-content" id="step-2">
                    <h1 class="text-gradient">Elige un Diseño</h1>
                    <p class="subtitle">Selecciona la planilla (template) que mejor se adapte a tu marca.</p>
                    
                    <input type="hidden" name="store_template" id="store_template" value="moderna">
                    
                    <div class="templates-grid">
                        <div class="template-card selected" onclick="selectTemplate('moderna', this)">
                            <div style="height:120px; background:linear-gradient(45deg, #10B981, #047857); border-radius:8px; margin-bottom:12px;"></div>
                            <h4>Moderna</h4>
                            <p>Limpia y directa, ideal para tecnología o variados.</p>
                        </div>
                        <div class="template-card" onclick="selectTemplate('elegante', this)">
                            <div style="height:120px; background:linear-gradient(45deg, #8B5CF6, #4C1D95); border-radius:8px; margin-bottom:12px;"></div>
                            <h4>Elegante</h4>
                            <p>Tonos oscuros, perfecta para joyería o moda.</p>
                        </div>
                        <div class="template-card" onclick="selectTemplate('minimalista', this)">
                            <div style="height:120px; background:linear-gradient(45deg, #F3F4F6, #9CA3AF); border-radius:8px; margin-bottom:12px;"></div>
                            <h4>Minimalista</h4>
                            <p>Enfocada 100% en las fotos de tus productos.</p>
                        </div>
                    </div>
                    
                    <div class="step-actions">
                        <button type="button" class="btn-prev" onclick="prevStep(1)">Atrás</button>
                        <button type="button" class="button button-primary btn-next" onclick="nextStep(3)">Continuar a Productos</button>
                    </div>
                </div>

                <!-- PASO 3: PRIMER PRODUCTO -->
                <div class="step-content" id="step-3">
                    <h1 class="text-gradient">Sube tu Primer Producto</h1>
                    <p class="subtitle">Estás a un paso. Añade tu primer producto para abrir tu tienda hoy.</p>
                    
                    <div class="form-group">
                        <label for="product_name">Nombre del Producto</label>
                        <input type="text" id="product_name" name="first_product_name" placeholder="Ej: Zapatos Deportivos X" required>
                    </div>

                    <div class="form-group">
                        <label for="product_price">Precio ($)</label>
                        <input type="number" id="product_price" name="first_product_price" step="0.01" placeholder="Ej: 29.99" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Foto del Producto</label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="first_product_image" accept="image/*" id="product-img-input" required>
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" style="margin-bottom:16px;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            <p id="product-img-text" style="margin:0; color:var(--text-main);">Sube la mejor foto de tu producto</p>
                        </div>
                    </div>

                    <div class="step-actions">
                        <button type="button" class="btn-prev" onclick="prevStep(2)">Atrás</button>
                        <button type="submit" class="button button-primary btn-next">¡Abrir mi Tienda!</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <?php wp_footer(); ?>
    <script>
        // Lógica de Steps
        function nextStep(step) {
            // Basic validation for Step 1
            if (step === 2) {
                const wa = document.getElementById('whatsapp').value;
                if (!wa) {
                    alert('Por favor, ingresa tu número de WhatsApp.');
                    return;
                }
            }
            
            // Validation for Step 2
            if (step === 3) {
                // If needed
            }
            
            document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
            document.getElementById('step-' + step).classList.add('active');
            
            // Actualizar indicadores
            document.getElementById('indicator-' + (step-1)).classList.remove('active');
            document.getElementById('indicator-' + (step-1)).classList.add('completed');
            document.getElementById('indicator-' + step).classList.add('active');
        }

        function prevStep(step) {
            document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
            document.getElementById('step-' + step).classList.add('active');
            
            // Actualizar indicadores
            document.getElementById('indicator-' + (step+1)).classList.remove('active');
            document.getElementById('indicator-' + step).classList.remove('completed');
            document.getElementById('indicator-' + step).classList.add('active');
        }

        // Selección de template
        function selectTemplate(templateName, element) {
            document.getElementById('store_template').value = templateName;
            document.querySelectorAll('.template-card').forEach(card => card.classList.remove('selected'));
            element.classList.add('selected');
        }

        // Efectos de subida de archivos
        document.getElementById('logo-input').addEventListener('change', (e) => {
            if(e.target.files.length > 0) {
                document.getElementById('logo-text').textContent = "Logo seleccionado: " + e.target.files[0].name;
                document.getElementById('logo-text').style.color = "var(--primary)";
            }
        });

        document.getElementById('product-img-input').addEventListener('change', (e) => {
            if(e.target.files.length > 0) {
                document.getElementById('product-img-text').textContent = "Foto seleccionada: " + e.target.files[0].name;
                document.getElementById('product-img-text').style.color = "var(--primary)";
            }
        });
    </script>
</body>
</html>
