<?php

namespace SimpleUserCRM\core\Database;

use SimpleUserCRM\constants\TableConstants;
use SimpleUserCRM\core\Database\Tables\ReferralsTable;
use SimpleUserCRM\core\Database\Tables\UsersTable;

class TableManager
{
    // Method to create the database tables
    public static function create_tables(): void {
        UsersTable::create();
        ReferralsTable::create();
    }
}