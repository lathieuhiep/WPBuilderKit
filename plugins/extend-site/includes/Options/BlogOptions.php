<?php
namespace ExtendSite\Options;

use Carbon_Fields\Field;

defined('ABSPATH') || exit;

class BlogOptions {

    public static function fields(): array {
        return [
            Field::make('select', 'es_blog_sidebar', __('Sidebar Position', 'extend-site'))
                ->set_options([
                    'right' => __('Right Sidebar', 'extend-site'),
                    'left'  => __('Left Sidebar', 'extend-site'),
                    'none'  => __('No Sidebar', 'extend-site'),
                ]),

            Field::make('checkbox', 'es_blog_show_author', __('Show Author', 'extend-site'))
                ->set_option_value('yes'),

            Field::make('checkbox', 'es_blog_show_date', __('Show Date', 'extend-site'))
                ->set_option_value('yes'),

            Field::make('image', 'es_blog_default_thumbnail', __('Default Thumbnail', 'extend-site')),
        ];
    }
}
