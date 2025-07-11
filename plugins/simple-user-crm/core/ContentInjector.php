<?php
namespace SimpleUserCRM\Core;

defined('ABSPATH') || exit;

class ContentInjector
{
    public static function init(): void
    {
        add_filter('the_content', [self::class, 'inject_register_page_form']);
    }

    public static function inject_register_page_form($content)
    {
        $page_id = get_option(Constants::KEY_OPTION_REGISTER_PAGE);

        if (!is_page($page_id) || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        return do_shortcode('[' . ShortcodeRegistry::get_shortcode_tag( ShortcodeRegistry::SHORTCODE_FORM_REGISTER ) . ']');
    }
}
