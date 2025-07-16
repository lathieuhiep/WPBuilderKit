<?php
namespace SimpleUserCRM\Constants;

defined('ABSPATH') || exit;

class PluginConstants
{
    // Define plugin constants
    public const VERSION = '1.0.0';
    public const TEXT_DOMAIN = 'simple-user-crm';

    // Define key options
    public const KEY_OPTION_REGISTER_PAGE = 'su_crm_register_page_id';

    // Define key meta fields
    public const KEY_LIMIT_PER_PAGE = 20;
    public const KEY_ORDER_BY = 'id DESC';

    public static function path(): string
    {
        return plugin_dir_path(dirname(__FILE__, 1));
    }

    public static function url(): string
    {
        return plugin_dir_url(dirname(__FILE__, 1));
    }
}
