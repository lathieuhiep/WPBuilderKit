<?php

namespace ExtendSite\Core;

use ExtendSite\PostType\PortfolioPostType;
use ExtendSite\ElementorAddon\ElementorAddon;

defined('ABSPATH') || exit;

class Plugin
{
    public function boot(): void
    {
        self::load_text_domain();
        self::includes();
        self::register_custom_post_types();
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
        require_once EXTEND_SITE_PATH . 'functions/helpers.php';
        require_once EXTEND_SITE_PATH . 'functions/cpt-helpers.php';
    }

    /**
     * Register custom post types.
     */
    public static function register_custom_post_types(): void
    {
       new PortfolioPostType();
    }

    /**
     * Load the Elementor addon.
     */
    private static function load_elementor_addon(): void
    {
        Enqueue::boot();
        ElementorAddon::boot();
    }
}