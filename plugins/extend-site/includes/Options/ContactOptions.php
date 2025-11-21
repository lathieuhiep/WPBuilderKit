<?php
namespace ExtendSite\Options;

use Carbon_Fields\Field;

defined('ABSPATH') || exit;

class ContactOptions
{
    public static function fields(): array
    {
        return [
            // Contact
            Field::make('text', 'es_hotline', esc_html__('Hotline', 'extend-site')),
            Field::make('text', 'es_email', esc_html__('Email', 'extend-site')),
            Field::make('textarea', 'es_address', esc_html__('Address', 'extend-site')),
        ];
    }
}