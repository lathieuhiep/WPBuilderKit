<?php

namespace ExtendSite\Core;

use Carbon_Fields\Carbon_Fields;
use ExtendSite\Fields\FieldsManager;
use ExtendSite\Options\GeneralOptions;
use ExtendSite\Options\ThemeOptions;
use ExtendSite\PostType\PortfolioPostType;
use ExtendSite\ElementorAddon\ElementorAddon;
use ExtendSite\PostType\TemplateLoader;

defined('ABSPATH') || exit;

class Plugin
{
    public function boot(): void
    {
        self::load_text_domain();
        self::load_enqueue();
        self::load_elementor_addon();
        self::load_custom_post_types();

        // Flush rewrite
        self::maybe_flush_rewrite();

        // Load Carbon Fields
        CarbonLoader::boot();

        // Load custom fields
        FieldsManager::boot();

        // Load Carbon Fields theme options
        ThemeOptions::boot();
    }

    /**
     * Load the plugin text domain for translations.
     */
    private static function load_text_domain(): void
    {
        load_plugin_textdomain(
            'extend-site',
            false,
            dirname(EXTEND_SITE_BASENAME) . '/languages'
        );
    }

    /**
     * Load core functionalities.
     */
    private static function load_enqueue(): void
    {
        Enqueue::boot();
    }

    /**
     * Load the Elementor addon.
     */
    private static function load_elementor_addon(): void
    {
        ElementorAddon::boot();
    }

    /**
     * Load custom post types.
     */
    private static function load_custom_post_types(): void
    {
        new PortfolioPostType();

        TemplateLoader::boot();
    }

    /**
     * Flush rewrite rules nếu có flag
     */
    private static function maybe_flush_rewrite(): void
    {
        if (get_option('extend_site_flush_rewrite')) {
            flush_rewrite_rules(false); // false = không ghi lại htaccess
            delete_option('extend_site_flush_rewrite');
        }
    }

    /**
     * Load Carbon Fields library.
     */
    private static function load_carbon_fields(): void {
        require_once EXTEND_SITE_PATH . 'vendor/carbon-fields/core/Carbon_Fields.php';

        Carbon_Fields::boot();
    }
}