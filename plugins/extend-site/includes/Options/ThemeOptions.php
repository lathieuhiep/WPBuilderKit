<?php

namespace ExtendSite\Options;

use Carbon_Fields\Container;

class ThemeOptions
{
    public static function boot(): void
    {
        add_action('carbon_fields_register_fields', [self::class, 'register']);
    }

    public static function register(): void
    {
        Container::make('theme_options', __('Theme Settings', 'extend-site'))
            ->set_icon('dashicons-admin-generic')
            ->set_page_menu_position(3)
            ->add_tab(__('General', 'extend-site'), GeneralOptions::fields())
            ->add_tab(__('Header', 'extend-site'), HeaderOptions::fields())
            ->add_tab(__('Footer', 'extend-site'), FooterOptions::fields())
            ->add_tab(__('Blog', 'extend-site'), BlogOptions::fields());
    }
}