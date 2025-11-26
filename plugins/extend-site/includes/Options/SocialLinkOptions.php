<?php
namespace ExtendSite\Options;

use Carbon_Fields\Field;
use ExtendSite\Constants\Social;

defined('ABSPATH') || exit;

class SocialLinkOptions extends OptionBase
{
    // key options
    private const SOCIAL_LINKS = 'es_opt_social_links';

    // option fields
    public static function fields(): array
    {
        $max = count(Social::list());

        return [
            // Social Links
            Field::make('complex', self::SOCIAL_LINKS, esc_html__('Social Links', 'extend-site'))
                ->set_layout('tabbed-vertical')
                ->set_max($max)
                ->add_fields([
                    Field::make('select', 'network', esc_html__('Network', 'extend-site'))
                        ->set_options(Social::list()),
                    Field::make('text', 'url', esc_html__('URL', 'extend-site')),
                ])
        ];
    }

    // get social list
    public function get_social_list()
    {
        $value = self::get(self::SOCIAL_LINKS);

        return !empty($value) ? $value : [];
    }
}