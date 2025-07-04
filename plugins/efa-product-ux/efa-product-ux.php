<?php
/**
 * Plugin Name: EFA Product UX for WooCommerce
 * Description: Bộ công cụ cải thiện trải nghiệm người dùng khi xem sản phẩm WooCommerce (Swatches, Sticky Cart, Quick View, ...).
 * Version: 1.0.0
 * Author: La Khắc Điệp
 * Author URI: https://example.com/
 * Text Domain: efa-product-ux
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once __DIR__ . '/inc/class-efa-product-ux.php';

add_action( 'plugins_loaded', function () {
    $plugin = new EFA_Product_UX();
    $plugin->init();
} );