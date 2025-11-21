<?php

namespace ExtendSite\Options;

use Carbon_Fields\Container;

class ThemeOptions
{
    private const PARENT_SLUG   = 'extend-site-theme-settings';
    private const THEME_OPTIONS = 'theme_options';

    public static function boot(): void
    {
        add_action('carbon_fields_register_fields', [self::class, 'register']);

        // Ẩn submenu "Theme Settings"
        add_action('admin_menu', function () {
            remove_submenu_page(self::PARENT_SLUG, self::PARENT_SLUG);
        }, 9999);

        // Redirect menu cha → General
        add_action('admin_menu', function () {
            if (! isset($_GET['page']) ) {
                return;
            }

            if ($_GET['page'] === self::PARENT_SLUG) {
                wp_safe_redirect(admin_url('admin.php?page=' . self::PARENT_SLUG . '-general'));
                exit;
            }
        }, 9999);
    }

    public static function register(): void
    {
        $parent = self::PARENT_SLUG;

        // Menu cha (sẽ bị ẩn)
        Container::make(self::THEME_OPTIONS, esc_html__('Theme Settings', 'extend-site'))
            ->set_page_file($parent)
            ->set_icon('dashicons-admin-generic')
            ->set_page_menu_position(3)
            ->add_fields([]);

        // GENERAL
        Container::make(self::THEME_OPTIONS, esc_html__('General', 'extend-site'))
            ->set_page_file($parent . '-general')
            ->set_page_parent($parent)
            ->add_fields( GeneralOptions::fields() );

        // HEADER
        Container::make(self::THEME_OPTIONS, esc_html__('Header', 'extend-site'))
            ->set_page_parent($parent)
            ->add_fields( HeaderOptions::fields() );

        // CONTACT
        Container::make(self::THEME_OPTIONS, esc_html__('Contact', 'extend-site'))
            ->set_page_parent($parent)
            ->add_fields( ContactOptions::fields() );

        // BLOG
        Container::make(self::THEME_OPTIONS, esc_html__('Blog', 'extend-site'))
            ->set_page_parent($parent)
            ->add_fields( BlogOptions::fields() );

        // SOCIAL
        Container::make(self::THEME_OPTIONS, esc_html__('Social Links', 'extend-site'))
            ->set_page_parent($parent)
            ->add_fields( SocialLinkOptions::fields() );

        // FOOTER
        Container::make(self::THEME_OPTIONS, esc_html__('Footer', 'extend-site'))
            ->set_page_parent($parent)
            ->add_fields( FooterOptions::fields() );
    }
}