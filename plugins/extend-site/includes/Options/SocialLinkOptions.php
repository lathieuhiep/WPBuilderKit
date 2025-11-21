<?php
namespace ExtendSite\Options;

use Carbon_Fields\Field;

defined('ABSPATH') || exit;

class SocialLinkOptions
{
    public static function fields(): array
    {
        return [
            // Social Links
            Field::make('complex', 'es_social_links', esc_html__('Social Links', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->add_fields([
                    Field::make('text', 'label', esc_html__('Network Name', 'extend-site')),
                    Field::make('text', 'icon_class', esc_html__('Icon Class', 'extend-site')),
                    Field::make('text', 'url', esc_html__('URL', 'extend-site')),
                ]),
        ];
    }
}