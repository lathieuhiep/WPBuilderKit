<?php

namespace ExtendSite\Core;

use ExtendSite\Admin\AdminManager\AdminManager;
use ExtendSite\Admin\AdminManager\Modules\BreadcrumbAdmin;
use ExtendSite\Admin\Options\ThemeOptions;
use ExtendSite\Constants\Config;
use ExtendSite\Core\Breadcrumb\BreadcrumbService;
use ExtendSite\ElementorAddon\ElementorAddon;
use ExtendSite\PostType\PostTypeManager;

defined('ABSPATH') || exit;

class Plugin
{
    public function boot(): void
    {
        // Load plugin text domain
        self::load_text_domain();

        // Load Admin Manager
        AdminManager::boot();

        // Load Carbon Fields
        CarbonLoader::boot();

        // Load Carbon Fields theme options
        ThemeOptions::boot();

        // Load asset enqueuing
        Enqueue::boot();

        // Load Elementor addon
        ElementorAddon::boot();

        // Load custom post types
        PostTypeManager::load();

        // Load breadcrumb module
        $this->boot_breadcrumb();
    }

    /**
     * Load the plugin text domain for translations.
     */
    public static function load_text_domain(): void
    {
        load_plugin_textdomain(
            'extend-site',
            false,
            dirname(Config::$basename) . '/languages'
        );
    }

    /**
     * Initialize breadcrumb module.
     */
    private function boot_breadcrumb(): void
    {
        $module = new BreadcrumbAdmin();

        if (!$module->is_enabled()) {
            return;
        }

        BreadcrumbService::instance()->boot();

        // Load public functions (function + shortcode)
        require_once Config::$path . '/includes/Core/Breadcrumb/functions.php';

        // (Chưa render, chỉ đảm bảo module sẵn sàng)
    }
}