<?php

namespace ExtendSite\Admin\AdminManager\Modules;

use ExtendSite\Admin\AdminManager\AdminManager;

defined('ABSPATH') || exit;

class BreadcrumbAdmin
{
    /**
     * Danh sách các fields cấu hình
     */
    private static function get_fields_config(): array
    {
        return [
            'es_breadcrumb_active' => [
                'label'   => __('Kích hoạt Breadcrumb', 'extend-site'),
                'type'    => 'checkbox',
                'default' => '1',
                'desc'    => __('Bật/Tắt hệ thống điều hướng.', 'extend-site')
            ],
            'es_breadcrumb_separator' => [
                'label'   => __('Ký tự phân cách', 'extend-site'),
                'type'    => 'text',
                'default' => '>',
                'desc'    => __('Ví dụ: >, » hoặc /', 'extend-site')
            ],
            'es_breadcrumb_home_text' => [
                'label'   => __('Chữ trang chủ', 'extend-site'),
                'type'    => 'text',
                'default' => __('Home', 'extend-site'),
                'desc'    => __('Thay đổi chữ "Trang chủ" hiển thị ở đầu.', 'extend-site')
            ],
            // Bạn có thể thêm 20 cái nữa ở đây chỉ với vài dòng...
        ];
    }

    public static function init(): void
    {
        add_action('admin_menu', [self::class, 'add_submenu']);
        add_action('admin_init', [self::class, 'register_settings']);
    }

    public static function add_submenu(): void
    {
        add_submenu_page('extend-site', 'Breadcrumb', 'Breadcrumb', 'manage_options', 'es-breadcrumb', [self::class, 'render_page']);
    }

    public static function register_settings(): void
    {
        $fields = self::get_fields_config();

        add_settings_section('es_breadcrumb_main_section', __('Cài đặt chi tiết', 'extend-site'), null, 'es-breadcrumb');

        foreach ($fields as $id => $args) {
            // Đăng ký từng option với database
            register_setting('es_breadcrumb_group', $id, [
                'sanitize_callback' => 'sanitize_text_field',
                'default'           => $args['default']
            ]);

            // Thêm field vào giao diện
            add_settings_field(
                $id,
                $args['label'],
                [self::class, 'render_generic_field'], // Dùng chung 1 hàm render
                'es-breadcrumb',
                'es_breadcrumb_main_section',
                array_merge(['id' => $id], $args) // Truyền tham số vào hàm render
            );
        }
    }

    /**
     * Hàm Render dùng chung cho mọi loại field
     */
    public static function render_generic_field(array $args): void
    {
        $value = get_option($args['id'], $args['default']);

        if ($args['type'] === 'checkbox') {
            printf(
                '<input type="checkbox" name="%1$s" value="1" %2$s>',
                esc_attr($args['id']),
                checked($value, '1', false)
            );
        } else {
            printf(
                '<input type="text" name="%1$s" value="%2$s" class="regular-text">',
                esc_attr($args['id']),
                esc_attr($value)
            );
        }

        if (!empty($args['desc'])) {
            printf('<p class="description">%s</p>', esc_html($args['desc']));
        }
    }

    public static function render_page(): void
    {
        AdminManager::render_view('breadcrumb-view', [
            'title' => __('Cấu hình Breadcrumb', 'extend-site')
        ]);
    }
}