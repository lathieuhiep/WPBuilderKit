<?php

namespace ExtendSite\Options;

use Carbon_Fields\Field;

defined('ABSPATH') || exit;

class HeaderOptions extends OptionBase
{

    // key options
    private const POSITION_FIXED_MENU = 'es_opt_position_fixed_menu';

    // option fields
    public static function fields(): array
    {

        return [
            // Display back to top
            Field::make('checkbox', self::POSITION_FIXED_MENU, esc_html__('Enable Position Fixed Menu', 'extend-site'))
                ->set_option_value('yes')
                ->set_default_value('yes'),
        ];
    }

    // get position fixed menu
    public function get_position_fixed_menu(): bool
    {
        return (bool)self::get(self::POSITION_FIXED_MENU, true);
    }
}
