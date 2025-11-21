<?php
/**
 * General Options
 *
 * @package ExtendSite
 */

namespace ExtendSite\Options;

use Carbon_Fields\Field;

defined('ABSPATH') || exit;

class GeneralOptions extends OptionBase
{

    // key options
    private const LOGO = 'es_opt_logo';
    private const ENABLE_LOADING = 'es_opt_enable_loading';
    private const LOADING_IMAGE = 'es_opt_loading_image';
    private const BACK_TO_TOP = 'es_opt_back_to_top';

    // option fields
    public static function fields(): array
    {

        return [
            // Logo & Branding
            Field::make('image', self::LOGO, esc_html__('Logo', 'extend-site'))
                ->set_value_type('id')
                ->set_help_text('Select your logo'),

            // -----------------------------
            // Loading Page
            // -----------------------------
            Field::make('checkbox', self::ENABLE_LOADING, esc_html__('Enable Loading Page', 'extend-site'))
                ->set_option_value('yes'),

            Field::make('image', self::LOADING_IMAGE, esc_html__('Loading Image', 'extend-site'))
                ->set_help_text(__('Upload GIF/PNG for loading animation', 'extend-site'))
                ->set_conditional_logic([
                    [
                        'field' => self::ENABLE_LOADING,
                        'value' => true,
                    ]
                ]),

            // Display back to top
            Field::make('checkbox', self::BACK_TO_TOP, esc_html__('Enable back to Top', 'extend-site'))
                ->set_option_value('yes')
                ->set_default_value('yes'),
        ];
    }

    // get logo
    public function get_logo_id($default = null)
    {
        $id = self::get(self::LOGO);

        return $id ?: $default;
    }

    // get display loading enabled
    public function get_loading_enabled(): bool
    {
        return (bool)self::get(self::ENABLE_LOADING, false);
    }

    // get image loading
    public function get_loading_image_id($default = null)
    {
        $id = self::get(self::LOADING_IMAGE);

        return $id ?: $default;
    }

    // get display back to top
    public function get_back_to_top_enabled(): bool
    {
        return (bool)self::get(self::BACK_TO_TOP, true);
    }
}
