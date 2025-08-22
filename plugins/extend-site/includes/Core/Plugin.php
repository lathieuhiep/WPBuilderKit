<?php
namespace ExtendSite\Core;

use ExtendSite\ElementorAddon\ElementorAddon;

defined('ABSPATH') || exit;

class Plugin
{
    public function boot(): void
    {
        self::load_text_domain();
        self::includes();
        self::load_elementor_addon();
    }

    /**
     * Load the plugin text domain for translations.
     */
    public static function load_text_domain(): void
    {
        load_plugin_textdomain(
            'extend-site',
            false,
            dirname( EXTEND_SITE_BASENAME ) . '/languages'
        );
    }

    private static function includes(): void
    {
        require_once EXTEND_SITE_PATH . 'includes/ElementorAddon/ElementorAddon.php';
    }

    /**
     * Load the Elementor addon.
     */
    private static function load_elementor_addon(): void
    {
        ElementorAddon::boot();
    }
}