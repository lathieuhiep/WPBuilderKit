<?php

namespace SimpleUserCRM\core\Database;

use SimpleUserCRM\core\Database\Tables\ReferralsTable;
use SimpleUserCRM\core\Database\Tables\UsersTable;

class TableManager
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