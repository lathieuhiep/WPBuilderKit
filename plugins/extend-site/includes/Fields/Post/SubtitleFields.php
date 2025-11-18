<?php

namespace ExtendSite\Fields\Post;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

defined('ABSPATH') || exit;

class SubtitleFields
{
    // Boot the SubtitleFields class.
    public static function boot(): void
    {
        add_action('carbon_fields_register_fields', [self::class, 'register']);
    }

    // Register subtitle fields.
    public static function register(): void
    {
        Container::make('post_meta', 'Slider Data')
            ->where('post_type', '=', 'post')
            ->add_fields(array(
                Field::make('association', 'related_posts', __('Related Posts'))
                    ->set_min(0)
                    ->set_types([
                        [
                            'type' => 'post',
                            'post_type' => 'post',
                        ],
                    ])

            ));

    }
}