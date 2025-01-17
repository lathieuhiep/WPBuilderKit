<?php
/**
 * Plugin Name: Essentials for Basic
 * Plugin URI: https://example.com/
 * Description: A plugin that provides additional widgets and features for Elementor.
 * Version: 1.0
 * Author: La Khắc Điệp
 * Author URI: https://example.com/
 * Text Domain: essentials-for-basic
 * Domain Path: /languages
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants
const EFB_PLUGIN_VERSION = '1.0';
define( 'EFB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'EFB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


// check active plugin elementor
add_action( 'plugins_loaded', 'efb_check_elementor' );
function efb_check_elementor(): void {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'efb_elementor_missing_notice' );

        return;
	}

	// Load core functionality
	require_once EFB_PLUGIN_PATH . 'includes/helpers.php';
	require_once EFB_PLUGIN_PATH . 'includes/enqueue.php';
	require_once EFB_PLUGIN_PATH . 'includes/widgets.php';

    // create category addons
	add_action( 'elementor/elements/categories_registered', 'efb_add_elementor_widget_categories' );
}

// notice not active elementor
function efb_elementor_missing_notice(): void {
	?>
    <div class="notice notice-error is-dismissible">
        <p><?php esc_html_e( 'Essentials for Basic plugin requires Elementor to be installed and activated.', 'essentials-for-basic' ); ?></p>
    </div>
	<?php
}

// Register widget category
function efb_add_elementor_widget_categories( $elements_manager ): void {
	$elements_manager->add_category(
		'efb-addons',
		[
			'title' => esc_html__( 'EFB Addons', 'essentials-for-basic' ),
			'icon'  => 'icon-goes-here',
		]
	);
}