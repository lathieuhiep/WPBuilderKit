<?php

namespace SimpleUserCRM\Admin;

use SimpleUserCRM\Constants\PluginConstants;

defined('ABSPATH') || exit;

class MenuPage
{
    public static function init(): void
    {
        add_action('admin_menu', [self::class, 'register_menu']);
        add_action('admin_init', [self::class, 'register_settings']);
    }

    // Returns an array of CRM pages with their details.
    public static function crm_pages(): array
    {
        return [
            'dashboard' => [
                'slug' => 'su_crm_dashboard',
                'title' => 'Tổng quan',
                'view' => 'dashboard/dashboard',
                'is_main' => true
            ],
            'user' => [
                'slug' => 'su_crm_user',
                'title' => 'Danh sách đăng kí',
                'view' => 'user/list',
            ],
            'settings' => [
                'slug' => 'su_crm_settings',
                'title' => 'Cài đặt',
                'view' => 'settings/settings',
            ]
        ];
    }

    // Returns an array of CRM page slugs.
    public static function crm_page_slugs(): array
    {
        return array_column(self::crm_pages(), 'slug');
    }

    // Determines if CRM assets should be loaded based on the current admin page.
    public static function should_load_crm_assets(): bool
    {
        return isset($_GET['page']) && in_array($_GET['page'], self::crm_page_slugs(), true);
    }


    // Registers the main menu and submenus for the CRM plugin.
    public static function register_menu(): void
    {
        add_menu_page(
            esc_html__('Quản Lý CRM', PluginConstants::TEXT_DOMAIN),
            esc_html__('Quản Lý CRM', PluginConstants::TEXT_DOMAIN),
            'manage_options',
            'su_crm_dashboard',
            self::make_render_callback('dashboard/dashboard'),
            'dashicons-admin-users',
            56
        );

        foreach (self::crm_pages() as $page) {
            if (!empty($page['is_main'])) continue;

            add_submenu_page(
                'su_crm_dashboard',
                $page['title'],
                $page['title'],
                'manage_options',
                $page['slug'],
                self::make_render_callback($page['view']),
            );
        }
    }

    // Creates a render callback for a specific view.
    protected static function make_render_callback($view): callable
    {
        return fn() => Layout::render($view);
    }

    public static function register_settings(): void
    {
        add_settings_section(
            'su_crm_page_section',
            esc_html__('Trang Plugin', PluginConstants::TEXT_DOMAIN),
            '',
            'su_crm_settings'
        );

        add_settings_field(
            PluginConstants::KEY_OPTION_REGISTER_PAGE,
            esc_html__('Trang đăng ký học viên', PluginConstants::TEXT_DOMAIN),
            [self::class, 'render_page_dropdown'],
            'su_crm_settings',
            'su_crm_page_section'
        );

        register_setting('su_crm_settings_group', PluginConstants::KEY_OPTION_REGISTER_PAGE);
    }

    public static function render_page_dropdown(): void
    {
        $selected = get_option(PluginConstants::KEY_OPTION_REGISTER_PAGE);
        wp_dropdown_pages([
            'name' => PluginConstants::KEY_OPTION_REGISTER_PAGE,
            'selected' => $selected,
            'show_option_none' => esc_html__('— Chọn một trang —', PluginConstants::TEXT_DOMAIN),
            'option_none_value' => '',
        ]);
    }
}
