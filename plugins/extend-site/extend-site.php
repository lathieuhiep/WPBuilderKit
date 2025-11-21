<?php
/**
 * Plugin Name:       Extend Site
 * Description:       Essential toolkit for WordPress: custom post types, widgets, and site extensions.
 * Version:           1.0.0
 * Author:            La Thieu Hiep
 * Text Domain:       extend-site
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Tested up to:      6.6
 * Requires PHP:      7.4
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

use ExtendSite\Core\Plugin;

defined('ABSPATH') || exit;

/**
 * -----------------------------------------------------
 * Constants
 * -----------------------------------------------------
 */
define('EXTEND_SITE_ACTIVE', true);
define('EXTEND_SITE_VERSION',  '1.0.0');
define('EXTEND_SITE_FILE',      __FILE__);
define('EXTEND_SITE_PATH',      plugin_dir_path(__FILE__));
define('EXTEND_SITE_URL',       plugin_dir_url(__FILE__));
define('EXTEND_SITE_BASENAME',  plugin_basename(__FILE__));

/**
 * -----------------------------------------------------
 * Boot plugin after all plugins loaded
 * -----------------------------------------------------
 */
add_action('plugins_loaded', static function () {

    // Load autoloader
    require_once EXTEND_SITE_PATH . 'includes/Core/Autoloader.php';

    \ExtendSite\Core\Autoloader::register();

    // Boot main plugin kernel
    (new Plugin())->boot();
});