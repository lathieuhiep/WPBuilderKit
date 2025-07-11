<?php

namespace SimpleUserCRM\Core;

defined('ABSPATH') || exit;

class Constants
{
    // Define plugin constants
    public const VERSION = '1.0.0';
    public const TEXT_DOMAIN = 'simple-user-crm';

    // Define key options
    public const KEY_OPTION_REGISTER_PAGE = 'su_crm_register_page_id';

    public static function path(): string
    {
        return plugin_dir_path(dirname(__FILE__, 1));
    }

    public static function url(): string
    {
        return plugin_dir_url(dirname(__FILE__, 1));
    }
}