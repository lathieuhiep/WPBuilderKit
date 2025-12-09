<?php
namespace ExtendSite\Options;

use Carbon_Fields\Field;

class InsertCodeOptions extends OptionBase
{
    private const PREFIX = 'es_opt_insert_code_';
    private const HEAD = self::PREFIX . 'head';
    private const AFTER_BODY = self::PREFIX . 'after_body';
    private const FOOTER = self::PREFIX . 'footer';

    // fields
    public static function fields(): array
    {
        return [
            // Insert into <head>
            Field::make('header_scripts', self::HEAD, esc_html__('Insert into head', 'extend-site'))
                ->set_rows( 10 ),

            // Insert after <body>
            Field::make('textarea', self::AFTER_BODY, esc_html__('Insert after body', 'extend-site'))
                ->set_rows( 10 ),

            // Insert into footer
            Field::make('footer_scripts', self::FOOTER, esc_html__('Insert into footer', 'extend-site'))
                ->set_rows( 10 ),
        ];
    }

    // get insert code head
    public function get_head_code(): string
    {
        return self::get(self::HEAD, '');
    }

    // get insert code after body
    public function get_after_body_code(): string
    {
        return self::get(self::AFTER_BODY, '');
    }

    // get insert code footer
    public function get_footer_code(): string
    {
        return self::get(self::FOOTER, '');
    }
}
