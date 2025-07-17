<?php
/**
 * Plugin Name: Simple User CRM
 * Description: Quản lý người dùng CRM.
 * Version: 1.0.0
 * Author: La Khắc Điệp
 * Author URI: https://example.com/
 * Text Domain: simple-user-crm
 * Domain Path: /languages
 *
 * Requires PHP: 8.2
 * Requires at least: 6.0
 */

defined('ABSPATH') || exit;

// Autoload classes in the SimpleUserCRM namespace
spl_autoload_register(function ($class) {
    if (str_starts_with($class, 'SimpleUserCRM\\')) {
        $relative_path = str_replace('\\', '/', substr($class, strlen('SimpleUserCRM\\')));
        $path = __DIR__ . '/' . $relative_path . '.php';

        if (file_exists($path)) {
            require_once $path;
        }
    }
});

// Activation hook to create necessary database tables
register_activation_hook(__FILE__, ['SimpleUserCRM\Core\Installer', 'activate']);

// Initialize the plugin
add_action('plugins_loaded', ['SimpleUserCRM\Core\Plugin', 'init']);
