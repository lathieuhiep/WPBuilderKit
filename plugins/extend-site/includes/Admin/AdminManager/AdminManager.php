<?php

namespace ExtendSite\Admin\AdminManager;

use ExtendSite\Admin\AdminManager\Modules\BreadcrumbAdmin;

defined('ABSPATH') || exit;

/**
 * Class AdminManager
 * Điều phối toàn bộ hoạt động quản trị của Framework.
 */
class AdminManager
{
    /**
     * Khởi tạo và đăng ký các module quản lý.
     */
    public static function boot(): void
    {
        // Đăng ký menu chính trước
        add_action('admin_menu', [self::class, 'register_main_menu']);

        // Khởi tạo các module con
        BreadcrumbAdmin::init();

        // Sau này thêm các module khác tại đây:
        // ElementorAdmin::init();
    }

    /**
     * Đăng ký Menu cha "Extend Site" ở sidebar.
     */
    public static function register_main_menu(): void
    {
        add_menu_page(
            esc_html__('Extend Site Framework', 'extend-site'),
            'Extend Site',
            'manage_options',
            'extend-site',
            [self::class, 'render_dashboard'],
            'dashicons-superhero', // Bạn có thể đổi icon tùy ý
            65
        );
    }

    /**
     * Hiển thị trang Dashboard tổng quan.
     */
    public static function render_dashboard(): void
    {
        self::render_view('dashboard-view', [
            'title' => esc_html__('Extend Site Dashboard', 'extend-site')
        ]);
    }

    /**
     * Helper render file HTML từ thư mục Views.
     * * @param string $view_name Tên file trong thư mục Views (không cần đuôi .php)
     * @param array $data Mảng dữ liệu truyền sang View
     */
    public static function render_view(string $view_name, array $data = []): void
    {
        $view_path = __DIR__ . '/Views/' . $view_name . '.php';

        if (file_exists($view_path)) {
            // Giải nén mảng thành các biến tự do (VD: $data['title'] thành $title)
            extract($data);

            include $view_path;
        }
    }
}