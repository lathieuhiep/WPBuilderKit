<?php
namespace SimpleUserCRM\Admin;

use SimpleUserCRM\Constants\PluginConstants;

defined('ABSPATH') || exit;

class MenuPage
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'register_menu']);
        add_action('admin_init', [$this, 'register_settings']);

        $this->hook_assets_if_needed();
    }

    public static function crm_pages(): array
    {
        return [
            'dashboard' => [
                'slug' => 'su_crm_dashboard',
                'title' => esc_html__('Tổng quan', PluginConstants::TEXT_DOMAIN)
            ],
            'students' => [
                'slug' => 'su_crm_students',
                'title' => esc_html__('Học viên', PluginConstants::TEXT_DOMAIN)
            ],
            'create' => [
                'slug' => 'su_crm_create',
                'title' => esc_html__('Tạo mới', PluginConstants::TEXT_DOMAIN)
            ],
            'reports' => [
                'slug' => 'su_crm_reports',
                'title' => esc_html__('Báo cáo', PluginConstants::TEXT_DOMAIN)
            ],
            'settings' => [
                'slug' => 'su_crm_settings',
                'title' => esc_html__('Cài đặt', PluginConstants::TEXT_DOMAIN)
            ]
        ];
    }

    public static function crm_page_slugs(): array
    {
        return array_column(self::crm_pages(), 'slug');
    }

    protected function should_load_crm_assets(): bool
    {
        return isset($_GET['page']) && in_array($_GET['page'], self::crm_page_slugs(), true);
    }

    protected function hook_assets_if_needed(): void
    {
        if (!$this->should_load_crm_assets()) {
            return;
        }

        add_action('admin_enqueue_scripts', function () {
            $path_assets_js = 'admin/assets/js/';
            $path_assets_css = 'admin/assets/css/';

            wp_enqueue_style('be-su-crm', PluginConstants::url() . $path_assets_css . 'be-su-crm.css', [], PluginConstants::VERSION);
            wp_enqueue_script('be-su-crm', PluginConstants::url() . $path_assets_js . 'be-su-crm.js', ['jquery'], PluginConstants::VERSION, true);
        });

        add_filter('admin_body_class', function ($classes) {
            return $classes . ' su-crm-admin';
        });
    }

    public function register_menu(): void
    {
        add_menu_page(
            esc_html__('Quản Lý CRM', PluginConstants::TEXT_DOMAIN),
            esc_html__('CRM Management', PluginConstants::TEXT_DOMAIN),
            'manage_options',
            'su_crm_dashboard',
            fn() => Layout::render('dashboard'),
            'dashicons-admin-users',
            56
        );

        foreach (self::crm_pages() as $key => $page) {
            if ($key === 'dashboard') continue;

            add_submenu_page(
                'su_crm_dashboard',
                $page['title'],
                $page['title'],
                'manage_options',
                $page['slug'],
                fn() => Layout::render($key)
            );
        }
    }

    public function register_settings(): void
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
            [$this, 'render_page_dropdown'],
            'su_crm_settings',
            'su_crm_page_section'
        );

        register_setting('su_crm_settings_group', PluginConstants::KEY_OPTION_REGISTER_PAGE);
    }

    public function render_page_dropdown(): void
    {
        $selected = get_option(PluginConstants::KEY_OPTION_REGISTER_PAGE);
        wp_dropdown_pages([
            'name'              => PluginConstants::KEY_OPTION_REGISTER_PAGE,
            'selected'          => $selected,
            'show_option_none'  => esc_html__('— Chọn một trang —', PluginConstants::TEXT_DOMAIN),
            'option_none_value' => '',
        ]);
    }
}
