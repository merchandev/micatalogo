<?php
namespace MiCatalogo;

class Multisite {
    public function __construct() {
        add_action( 'wpmu_new_blog', [ $this, 'provision_new_site' ], 10, 6 );
    }

    public function provision_new_site( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
        // Cambiar tema, crear páginas, asignar rol, etc.
    }
}
