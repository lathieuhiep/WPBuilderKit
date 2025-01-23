<?php
/**
 * Plugin Name: Essential Features Addon
 * Plugin URI: https://example.com/
 * Description: A plugin that provides additional widgets and features for Elementor.
 * Version: 1.0
 * Author: La Khắc Điệp
 * Author URI: https://example.com/
 * Text Domain: essential-features-addon
 * Domain Path: /languages
 */

// prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// define constants
const EFA_PLUGIN_VERSION = '1.0';
define( 'EFA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'EFA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// load core functionality
require_once EFA_PLUGIN_PATH . 'includes/helpers.php';
require_once EFA_PLUGIN_PATH . 'includes/enqueue.php';

// include cpt
require_once EFA_PLUGIN_PATH . 'includes/cpt/post-type-portfolio.php';
require_once EFA_PLUGIN_PATH . 'includes/inc-templates.php';

// include wp-custom
require_once EFA_PLUGIN_PATH . 'includes/inc-wp-custom.php';

// check active plugin elementor
add_action( 'plugins_loaded', 'efa_check_elementor' );
function efa_check_elementor(): void {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'efa_elementor_missing_notice' );

        return;
	}

	// include widget addons elementor
	require_once EFA_PLUGIN_PATH . 'includes/inc-elementor.php';

    // create category addons
	add_action( 'elementor/elements/categories_registered', 'efa_add_elementor_widget_categories' );
}

// notice not active elementor
function efa_elementor_missing_notice(): void {
	?>
    <div class="notice notice-error is-dismissible">
        <p><?php esc_html_e( 'Plugin Essential Features Addon có phần mở rộng addon cho plugin Elementor. Nếu muốn sử dụng bạn cần cài plugin Elementor và kích hoạt.', 'essential-features-addon' ); ?></p>
    </div>
	<?php
}

// Register widget category
function efa_add_elementor_widget_categories( $elements_manager ): void {
	$elements_manager->add_category(
		'efa-addons',
		[
			'title' => esc_html__( 'Essential Features Addons', 'essential-features-addon' ),
			'icon'  => 'icon-goes-here',
		]
	);
}