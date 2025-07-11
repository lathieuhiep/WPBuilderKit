<?php

namespace SimpleUserCRM\Frontend;

use SimpleUserCRM\Core\Constants;

defined('ABSPATH') || exit;

class Frontend
{
    public static function init(): void
    {

        // Enqueue frontend assets
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_assets']);
    }

    public static function enqueue_assets(): void
    {
        $path_assets_css = 'frontend/assets/css/';
        $path_assets_js = 'frontend/assets/js/';

        $register_page_id = get_option(Constants::KEY_OPTION_REGISTER_PAGE);

        if ( is_page($register_page_id) || has_shortcode(get_post()->post_content, 'crm-register') ) {
            wp_enqueue_style('fe-su-crm', Constants::url() . $path_assets_css . 'fe-su-crm.css', [], Constants::VERSION);
        }
    }
}