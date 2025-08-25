<?php
/**
 * Plugin Name: Extend Site
 * Description: Essential toolkit for WordPress: custom post types, widgets, and site extensions.
 * Version:     1.0.0
 * Author:      La Thieu Hiep
 * Text Domain: extend-site
 * Requires at least: 6.0
 * Tested up to: 6.6
 * Requires PHP: 7.4
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

use ExtendSite\Core\Autoloader;
use ExtendSite\Core\Plugin;

defined('ABSPATH') || exit;

// Define constants for the plugin
const EXTEND_SITE_VERSION = '1.0.0';
const EXTEND_SITE_FILE = __FILE__;

// Plugin paths and URLs
define('EXTEND_SITE_PATH', plugin_dir_path(EXTEND_SITE_FILE));
define('EXTEND_SITE_URL',  plugin_dir_url(EXTEND_SITE_FILE));
define('EXTEND_SITE_BASENAME', plugin_basename(EXTEND_SITE_FILE));

// Load the plugin
add_action('plugins_loaded', static function () {
    require_once EXTEND_SITE_PATH . 'includes/Core/Autoloader.php';
    Autoloader::register();

    (new Plugin())->boot();
});