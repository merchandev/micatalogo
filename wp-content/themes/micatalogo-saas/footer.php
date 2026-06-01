<?php
/**
 * Footer genérico del tema
 */
?>
<footer id="colophon" class="site-footer" style="padding: 40px 0; border-top: 1px solid var(--border); background: var(--bg-dark);">
    <div class="container">
        <div class="site-info" style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
            <p style="color: var(--text-muted); text-align: center; margin-bottom: 0;">&copy; <?php echo date( 'Y' ); ?> MiCatálogo Venezuela, C.A. Todos los derechos reservados.</p>
            <nav class="footer-navigation">
                <ul style="list-style: none; padding: 0; display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin: 0;">
                    <li><a href="/legal/?tab=terminos" style="color: var(--text-muted); text-decoration: none; font-size: 0.95rem; transition: color 0.3s;" onmouseover="this.style.color='#FFF'" onmouseout="this.style.color='var(--text-muted)'">Términos y condiciones</a></li>
                    <li><a href="/legal/?tab=privacidad" style="color: var(--text-muted); text-decoration: none; font-size: 0.95rem; transition: color 0.3s;" onmouseover="this.style.color='#FFF'" onmouseout="this.style.color='var(--text-muted)'">Política de privacidad</a></li>
                    <li><a href="/legal/?tab=cookies" style="color: var(--text-muted); text-decoration: none; font-size: 0.95rem; transition: color 0.3s;" onmouseover="this.style.color='#FFF'" onmouseout="this.style.color='var(--text-muted)'">Política de cookies</a></li>
                </ul>
            </nav>
            <div class="social-links" style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 15px; margin-top: 5px;">
                <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.95rem; transition: color 0.3s;" onmouseover="this.style.color='#FFF'" onmouseout="this.style.color='var(--text-muted)'">Instagram</a>
                <span style="color: var(--border); font-size: 0.8rem;">|</span>
                <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.95rem; transition: color 0.3s;" onmouseover="this.style.color='#FFF'" onmouseout="this.style.color='var(--text-muted)'">TikTok</a>
                <span style="color: var(--border); font-size: 0.8rem;">|</span>
                <a href="#" style="color: var(--text-muted); text-decoration: none; font-size: 0.95rem; transition: color 0.3s;" onmouseover="this.style.color='#FFF'" onmouseout="this.style.color='var(--text-muted)'">Facebook</a>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
