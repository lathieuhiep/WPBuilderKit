<?php
namespace SimpleUserCRM\Core;

use SimpleUserCRM\Core\Database\ReferralsTable;
use SimpleUserCRM\Core\Database\UsersTable;

defined('ABSPATH') || exit;
class Database
{
    // Constants for table names
    public const TABLE_USERS = 'su_crm_users';
    public const TABLE_REFERRALS = 'su_crm_referrals';

    // Method to create the users table
    public static function table_users(): string
    {
        global $wpdb;

        return $wpdb->prefix . self::TABLE_USERS;
    }

    // Method to create the referrals table
    public static function table_referrals(): string
    {
        global $wpdb;

        return $wpdb->prefix . self::TABLE_REFERRALS;
    }

    // Method to create the database tables
    public static function create_tables(): void {
        UsersTable::create();
        ReferralsTable::create();
    }
}