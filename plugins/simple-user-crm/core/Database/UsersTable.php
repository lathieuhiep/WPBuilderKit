<?php
namespace SimpleUserCRM\Core\Database;

use SimpleUserCRM\Core\Database;

class UsersTable
{
    public static function create(): void
    {
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $table = Database::table_users();
        $charset = $wpdb->get_charset_collate();

        $sql = "
            CREATE TABLE $table (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                full_name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                phone VARCHAR(20) NOT NULL,
                birth_date DATE DEFAULT NULL,
                address TEXT,
                referral_code VARCHAR(100) UNIQUE,
                referred_by VARCHAR(100),
                source VARCHAR(100),
                note TEXT,
                status VARCHAR(50) NOT NULL DEFAULT 'pending',
                wp_user_id BIGINT(20),
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT NULL,
                PRIMARY KEY  (id),
                UNIQUE KEY email (email),
                KEY phone (phone),
                KEY referred_by (referred_by),
                KEY status (status),
                KEY wp_user_id (wp_user_id),
                KEY created_at (created_at),
                KEY updated_at (updated_at)
            ) $charset;
        ";

        dbDelta($sql);
    }
}