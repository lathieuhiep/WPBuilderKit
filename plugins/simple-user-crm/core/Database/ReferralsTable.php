<?php
namespace SimpleUserCRM\Core\Database;

use SimpleUserCRM\Core\Database;

class ReferralsTable
{
    public static function create(): void
    {
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $table = Database::table_referrals();
        $charset = $wpdb->get_charset_collate();

        $sql = "
            CREATE TABLE $table (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                referrer_code VARCHAR(100) NOT NULL,
                referred_email VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                note TEXT,
                PRIMARY KEY  (id),
                KEY referrer_code (referrer_code),
                KEY referred_email (referred_email),
                KEY created_at (created_at)
            ) $charset;
        ";

        dbDelta($sql);
    }
}