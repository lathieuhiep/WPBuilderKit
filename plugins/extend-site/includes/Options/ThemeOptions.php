<?php

namespace ExtendSite\Options;

use Carbon_Fields\Container;

defined('ABSPATH') || exit;

class ThemeOptions
{
    public static function boot(): void
    {
        add_action('carbon_fields_register_fields', [self::class, 'register']);
    }

    public static function register(): void
    {
        $container = Container::make('theme_options', esc_html__('Theme Settings', 'extend-site'))
            ->set_icon('dashicons-admin-generic')
            ->set_page_menu_position(3)
            ->add_tab(
                esc_html__('General', 'extend-site'),
                GeneralOptions::fields()
            )
            ->add_tab(
                esc_html__('Header', 'extend-site'),
                HeaderOptions::fields()
            )
            ->add_tab(
                esc_html__('Contact', 'extend-site'),
                ContactOptions::fields()
            )
            ->add_tab(
                esc_html__('Blog - Archive', 'extend-site'),
                PostArchiveOptions::fields()
            )
            ->add_tab(
                esc_html__('Blog - Single', 'extend-site'),
                SinglePostOptions::fields()
            )
            ->add_tab(
                esc_html__('Social Links', 'extend-site'),
                SocialLinkOptions::fields()
            );

        // Thêm mô-đun Woo ONLY nếu WooCommerce đang active
        if ( class_exists('WooCommerce') ) {
            $container->add_tab(
                esc_html__('WooCommerce', 'extend-site'),
                WooOptions::fields()
            );

            $container->add_tab(
                esc_html__('WooCommerce Single', 'extend-site'),
                WooSingleOptions::fields()
            );
        }

        // Footer tab and other tabs
        $container->add_tab(
            esc_html__('Footer', 'extend-site'),
            FooterOptions::fields()
        )->add_tab(
            esc_html__('Copyright', 'extend-site'),
            CopyrightOptions::fields()
        )->add_tab(
            esc_html__('Insert Code', 'extend-site'),
            InsertCodeOptions::fields()
        );
    }
}
