<?php
declare(strict_types=1);

final class EFA_Swatches_DB
{
    public static function create_tables(): void
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $attribute_table = $wpdb->prefix . 'efa_product_swatches_attributes';
        $term_meta_table = $wpdb->prefix . 'efa_product_swatches_term_meta';

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $sql = [];

        // Create attributes table
        $sql[] = "CREATE TABLE $attribute_table (
            id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            attribute_id    BIGINT UNSIGNED NOT NULL UNIQUE,
            display_type    VARCHAR(50) NOT NULL DEFAULT 'button',
            custom_settings LONGTEXT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        // Create term meta table
        $sql[] = "CREATE TABLE $term_meta_table (
            id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            term_id       BIGINT UNSIGNED NOT NULL,
            attribute_id  BIGINT UNSIGNED NOT NULL,
            meta_key      VARCHAR(100) NOT NULL,
            meta_value    LONGTEXT NULL,
            PRIMARY KEY (id),
            KEY term_key  (term_id, meta_key),
            KEY attr_key  (attribute_id)
        ) $charset_collate;";

        // Execute the SQL queries
        foreach ( $sql as $query ) {
            dbDelta( $query );
        }
    }
}