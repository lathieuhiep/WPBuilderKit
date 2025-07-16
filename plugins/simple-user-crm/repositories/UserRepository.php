<?php
namespace SimpleUserCRM\Repositories;

use SimpleUserCRM\Constants\PluginConstants;
use SimpleUserCRM\Constants\TableConstants;
use SimpleUserCRM\Core\Database\DBHelper;

defined('ABSPATH') || exit;

class UserRepository
{
    // get user list
    public static function list(
        int $offset = 0,
        array $filters = [],
        string $columns = '*',
        int $limit = PluginConstants::KEY_LIMIT_PER_PAGE,
        $order_by = PluginConstants::KEY_ORDER_BY
    ): array
    {
        return DBHelper::get_advanced_slice(TableConstants::table_users(), $offset, $filters, $columns, $limit, $order_by);
    }

    // get total of users
    public static function count(array $filters = []): int
    {
        return DBHelper::count_advanced(TableConstants::table_users(), $filters);
    }
}