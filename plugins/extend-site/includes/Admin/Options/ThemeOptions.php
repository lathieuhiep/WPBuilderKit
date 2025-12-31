<?php

namespace ExtendSite\Admin\Options;

use Carbon_Fields\Container;
use ExtendSite\Admin\Options\Modules\ContactOptions;
use ExtendSite\Admin\Options\Modules\CopyrightOptions;
use ExtendSite\Admin\Options\Modules\FooterOptions;
use ExtendSite\Admin\Options\Modules\GeneralOptions;
use ExtendSite\Admin\Options\Modules\HeaderOptions;
use ExtendSite\Admin\Options\Modules\InsertCodeOptions;
use ExtendSite\Admin\Options\Modules\PostArchiveOptions;
use ExtendSite\Admin\Options\Modules\SinglePostOptions;
use ExtendSite\Admin\Options\Modules\SocialLinkOptions;
use ExtendSite\Admin\Options\Modules\WooOptions;
use ExtendSite\Admin\Options\Modules\WooSingleOptions;

defined('ABSPATH') || exit;

class ThemeOptions
{
    // Khởi tạo hook để đăng ký các tùy chọn
    public static function boot(): void
    {
        add_action('carbon_fields_register_fields', [self::class, 'register']);
    }

    // Đăng ký các tùy chọn chủ đề
    public static function register(): void
    {
        // 1. Định nghĩa các Tab mặc định
        $tabs = [
            ['label' => esc_html__('General', 'extend-site'), 'class' => GeneralOptions::class],
            ['label' => esc_html__('Header', 'extend-site'), 'class' => HeaderOptions::class],
            ['label' => esc_html__('Contact', 'extend-site'), 'class' => ContactOptions::class],
            ['label' => esc_html__('Blog - Archive', 'extend-site'), 'class' => PostArchiveOptions::class],
            ['label' => esc_html__('Blog - Single', 'extend-site'), 'class' => SinglePostOptions::class],
            ['label' => esc_html__('Social Links', 'extend-site'), 'class' => SocialLinkOptions::class],
        ];

        // 2. Kiểm tra điều kiện WooCommerce
        if (class_exists('WooCommerce')) {
            $tabs[] = ['label' => esc_html__('WooCommerce', 'extend-site'), 'class' => WooOptions::class];
            $tabs[] = ['label' => esc_html__('WooCommerce Single', 'extend-site'), 'class' => WooSingleOptions::class];
        }

        // 3. Thêm các Tab cuối cùng
        $extra_tabs = [
            ['label' => esc_html__('Footer', 'extend-site'), 'class' => FooterOptions::class],
            ['label' => esc_html__('Copyright', 'extend-site'), 'class' => CopyrightOptions::class],
            ['label' => esc_html__('Insert Code', 'extend-site'), 'class' => InsertCodeOptions::class],
        ];

        $tabs = array_merge($tabs, $extra_tabs);

        // 4. Khởi tạo Container
        $container = Container::make('theme_options', esc_html__('Theme Settings', 'extend-site'))
            ->set_icon('dashicons-admin-generic')
            ->set_page_menu_position(3);

        // 5. Vòng lặp đăng ký tự động
        foreach ($tabs as $tab) {
            $class = $tab['class'];
            if (class_exists($class)) {
                $container->add_tab($tab['label'], $class::fields()); // Gọi fields() từ class tương ứng
            }
        }
    }
}
