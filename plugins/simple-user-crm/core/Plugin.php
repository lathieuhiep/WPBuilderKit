<?php
namespace SimpleUserCRM\Core;

use SimpleUserCRM\Admin\MenuPage;
use SimpleUserCRM\Frontend\Frontend;

defined('ABSPATH') || exit;

class Plugin
{
    public static function init(): void
    {
        // Load core modules
        CoreLoader::boot();

        // Enqueue asset
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_admin_assets']);

        // check load admin or frontend
        if (is_admin()) {
            self::load_admin();
        } else {
            self::load_frontend();
        }
    }

    protected static function load_admin(): void
    {
        if (!class_exists('\SimpleUserCRM\Admin\MenuPage')) return;

        new MenuPage();
    }

    protected static function load_frontend(): void
    {
        if ( !class_exists( '\SimpleUserCRM\Frontend\Frontend' ) ) return;

        Frontend::init();
    }

    public static function enqueue_assets(): void
    {
        // Ví dụ: enqueue file form.css nếu có
        // wp_enqueue_style('sucrm-frontend', plugins_url('../frontend/Assets/form.css', __FILE__), [], '1.0.0');
    }

    public static function enqueue_admin_assets(): void
    {
        // Ví dụ: enqueue bảng danh sách admin
        // wp_enqueue_style('sucrm-admin', plugins_url('../admin/Assets/admin.css', __FILE__), [], '1.0.0');
    }
}