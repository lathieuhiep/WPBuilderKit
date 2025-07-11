<?php

namespace SimpleUserCRM\Core;

defined('ABSPATH') || exit;

class Installer
{
    // This method is called when the plugin is activated
    public static function activate(): void
    {
        Database::create_tables();
        self::create_register_pages();
    }

    // This method creates a registration page if it doesn't exist
    protected static function create_register_pages(): void
    {
        $option_key = Constants::KEY_OPTION_REGISTER_PAGE;
        $title = 'Đăng ký thành viên';

        // check if the page already exists
        $page_id = get_option($option_key);
        if ($page_id && get_post_status($page_id) === 'publish') {
            return;
        }

        // check if a page with the same title already exists
        $existing = get_posts([
            'post_type' => 'page',
            'title' => $title,
            'post_status' => 'publish',
            'numberposts' => 1,
        ]);

        if (!empty($existing)) {
            update_option($option_key, $existing[0]->ID);
            return;
        }

        $new_id = wp_insert_post([
            'post_title' => $title,
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_content' => '',
        ]);

        if (!is_wp_error($new_id)) {
            update_option($option_key, $new_id);
        }
    }
}