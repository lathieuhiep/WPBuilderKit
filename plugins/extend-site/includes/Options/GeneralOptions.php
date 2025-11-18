<?php
/**
 * General Options
 *
 * @package ExtendSite
 */

namespace ExtendSite\Options;

use Carbon_Fields\Field;

defined('ABSPATH') || exit;

class GeneralOptions {

    public static function fields(): array {

        return [

            // Logo & Branding
            Field::make('image', 'es_logo', __('Logo (Desktop)', 'extend-site')),
            Field::make('image', 'es_logo_mobile', __('Logo (Mobile)', 'extend-site')),
            Field::make('image', 'es_favicon', __('Favicon', 'extend-site')),
            Field::make('text', 'es_tagline', __('Tagline', 'extend-site')),

            // Contact
            Field::make('text', 'es_hotline', __('Hotline', 'extend-site')),
            Field::make('text', 'es_email', __('Email', 'extend-site')),
            Field::make('textarea', 'es_address', __('Address', 'extend-site')),

            // Social Links
            Field::make('complex', 'es_social_links', __('Social Links', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->add_fields([
                    Field::make('text', 'label', __('Network Name', 'extend-site')),
                    Field::make('text', 'icon_class', __('Icon Class', 'extend-site')),
                    Field::make('text', 'url', __('URL', 'extend-site')),
                ]),

            // Display
            Field::make('checkbox', 'es_back_to_top', __('Enable Back to Top', 'extend-site'))
                ->set_option_value('yes'),

            Field::make('text', 'es_copyright', __('Copyright', 'extend-site')),
        ];
    }
}
