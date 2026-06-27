<?php

namespace ExtendSite\Admin\AdminManager;

use ExtendSite\Admin\AdminManager\Modules\BreadcrumbAdmin;
use ExtendSite\Constants\Config;

defined('ABSPATH') || exit;

/**
 * Kernel điều phối toàn bộ Admin Menu Framework
 */
final class AdminManager
{
    /**
     * Boot admin framework
     */
    public static function boot(): void
    {
        add_action('admin_menu', [self::class, 'register']);
    }

    public static function register(): void
    {
        self::register_main_menu();
        self::boot_modules();
    }

    /**
     * Register main menu "Extend Site"
     */
    public static function register_main_menu(): void
    {
        add_menu_page(
            esc_html__('Extend Site Framework', 'extend-site'),
            esc_html__('Extend Site', 'extend-site'),
            AdminConstants::CAPABILITY_MANAGE,
            AdminConstants::MENU_PARENT,
            [self::class, 'render_dashboard'],
            'dashicons-superhero',
            65
        );
    }

    /**
     * Boot all admin modules
     */
    protected static function boot_modules(): void
    {
        foreach (self::get_modules() as $module) {
            if ($module instanceof BaseAdminModule) {
                $module->boot();
            }
        }
    }

    /**
     * Danh sách các module admin
     */
    protected static function get_modules(): array
    {
        return [
            new BreadcrumbAdmin(),
            // new SeoAdmin(),
            // new SchemaAdmin(),
        ];
    }

    /**
     * Render dashboard page
     */
    public static function render_dashboard(): void
    {
        self::render_view('dashboard-view', [
            'title' => esc_html__('Extend Site Dashboard', 'extend-site'),
        ]);
    }

    /**
     * Render admin view
     */
    protected static function render_view(string $view, array $data = []): void
    {
        $path = Config::$path . AdminConstants::PATH_VIEWS . $view . '.php';

        if (is_readable($path)) {
            extract($data, EXTR_SKIP);

            require $path;
        }
    }
}