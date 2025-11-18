<?php
namespace ExtendSite\Options;

use Carbon_Fields\Field;

defined('ABSPATH') || exit;

class HeaderOptions {

    public static function fields(): array {

        return [
            Field::make('select', 'es_header_layout', __('Header Layout', 'extend-site'))
                ->set_options([
                    'default' => __('Default', 'extend-site'),
                    'minimal' => __('Minimal', 'extend-site'),
                    'sticky'  => __('Sticky', 'extend-site'),
                ]),

            Field::make('checkbox', 'es_topbar_enable', __('Enable Top Bar', 'extend-site'))
                ->set_option_value('yes'),

            Field::make('text', 'es_topbar_text', __('Top Bar Text', 'extend-site'))
                ->set_help_text(__('Visible when Top Bar is enabled.', 'extend-site')),

            Field::make('text', 'es_header_cta_label', __('CTA Button Label', 'extend-site')),
            Field::make('text', 'es_header_cta_link', __('CTA Button Link', 'extend-site')),
        ];
    }
}
