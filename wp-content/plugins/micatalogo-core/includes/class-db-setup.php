<?php
namespace MiCatalogo;

class DB_Setup {
    public static function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'mc_productos';

        $sql = "CREATE TABLE $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            vendor_id bigint(20) unsigned NOT NULL,
            title varchar(255) NOT NULL,
            description longtext NOT NULL,
            price decimal(10,2) NOT NULL DEFAULT '0.00',
            image_id bigint(20) unsigned DEFAULT NULL,
            status varchar(20) NOT NULL DEFAULT 'publish',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY vendor_id (vendor_id),
            KEY status (status)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    public static function migrate_old_products() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'mc_productos';

        $args = [
            'post_type'      => 'producto',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];
        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                $vendor_id = $post->post_author;
                $price = get_post_meta($post->ID, '_price', true) ?: '0.00';
                $image_id = get_post_thumbnail_id($post->ID) ?: null;

                $wpdb->insert(
                    $table_name,
                    [
                        'vendor_id' => $vendor_id,
                        'title' => $post->post_title,
                        'description' => $post->post_content,
                        'price' => $price,
                        'image_id' => $image_id,
                        'status' => 'publish',
                        'created_at' => current_time('mysql'),
                    ],
                    ['%d', '%s', '%s', '%f', '%d', '%s', '%s']
                );

                // Optionally, change status to 'draft' or 'trash' so it doesn't get migrated twice
                wp_update_post([
                    'ID' => $post->ID,
                    'post_status' => 'trash'
                ]);
            }
        }
    }
}
