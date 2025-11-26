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
        Container::make('theme_options', esc_html__('Theme Settings', 'extend-site'))
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
            )
            ->add_tab(
                esc_html__('Footer', 'extend-site'),
                FooterOptions::fields()
            );
    }
}
