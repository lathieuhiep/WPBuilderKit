<?php
namespace ExtendSite\Core;

use Carbon_Fields\Carbon_Fields;

defined('ABSPATH') || exit;

class CarbonLoader
{
    /**
     * Load Carbon Fields library.
     */
    public static function boot(): void
    {
        add_action('after_setup_theme', [self::class, 'load_carbon_fields'], 5);
    }

    /**
     * Load Carbon Fields.
     */
    public static function load_carbon_fields(): void {
        // Path tới thư mục carbon-fields
        $path = EXTEND_SITE_PATH . 'libraries/carbon-fields/vendor/autoload.php';

        if ( file_exists($path) ) {
            require_once $path;

            Carbon_Fields::boot();
        }
    }

}