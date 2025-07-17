<?php
namespace SimpleUserCRM\Admin;

use SimpleUserCRM\Constants\PluginConstants;

defined( 'ABSPATH' ) || exit;

class AssetsEnqueue
{
    public static function init(): void
    {
        self::hook_assets_if_needed();
    }

    protected static function hook_assets_if_needed(): void
    {
        if (!MenuPage::should_load_crm_assets()) {
            return;
        }

        add_action('admin_enqueue_scripts', function () {
            $path_assets_js = 'admin/assets/js/';
            $path_assets_css = 'admin/assets/css/';

            wp_enqueue_style('be-su-crm', PluginConstants::url() . $path_assets_css . 'be-su-crm.min.css', [], PluginConstants::VERSION);
            wp_enqueue_script('be-su-crm', PluginConstants::url() . $path_assets_js . 'be-su-crm.js', ['jquery'], PluginConstants::VERSION, true);
        });

        add_filter('admin_body_class', function ($classes) {
            return $classes . ' su-crm-admin';
        });
    }
}