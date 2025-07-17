<?php
namespace SimpleUserCRM\Core;

use SimpleUserCRM\Admin\Admin;
use SimpleUserCRM\Constants\PluginConstants;
use SimpleUserCRM\Frontend\Frontend;

defined('ABSPATH') || exit;

class Plugin
{
    public static function init(): void
    {
        // Load plugin text domain for translations
        self::loadTextDomain();

        // Load core modules
        CoreLoader::boot();

        // check load admin or frontend
        if (is_admin()) {
            self::load_admin();
        } else {
            self::load_frontend();
        }
    }

    public static function loadTextDomain(): void
    {
        load_plugin_textdomain(PluginConstants::TEXT_DOMAIN, false, PluginConstants::path() . '/languages');
    }

    protected static function load_admin(): void
    {
        if (!class_exists('\SimpleUserCRM\Admin\Admin')) return;

        Admin::init();
    }

    protected static function load_frontend(): void
    {
        if ( !class_exists( '\SimpleUserCRM\Frontend\Frontend' ) ) return;

        Frontend::init();
    }
}