<?php
namespace ExtendSite\Options;

use Carbon_Fields\Field;

defined('ABSPATH') || exit;

class FooterOptions {

    public static function fields(): array {
        return [

            Field::make('textarea', 'es_footer_about', __('Footer About Text', 'extend-site')),
            Field::make('image', 'es_footer_logo', __('Footer Logo', 'extend-site')),

            Field::make('text', 'es_footer_menu_title', __('Footer Menu Title', 'extend-site')),

            Field::make('checkbox', 'es_footer_social', __('Show Social Links in Footer', 'extend-site'))
                ->set_option_value('yes'),

            Field::make('textarea', 'es_footer_bottom_text', __('Footer Bottom Text', 'extend-site'))
                ->set_help_text(__('HTML allowed.', 'extend-site')),

            Field::make('text', 'es_copyright', esc_html__('Copyright', 'extend-site')),
        ];
    }
}
