<?php

//Register front end woo
add_action('wp_enqueue_scripts', 'basictheme_register_front_end_woo');

function basictheme_register_front_end_woo(): void {
	// css
	wp_enqueue_style( 'shop', get_theme_file_uri( '/includes/woocommerce/assets/css/shop.min.css' ), array(), basictheme_get_version_theme() );

	// js
	wp_enqueue_script( 'woo-quick-view', get_theme_file_uri( '/includes/woocommerce/assets/js/woo-quick-view.min.js' ), array('jquery', 'wc-add-to-cart-variation'), '', true );

	$basictheme_woo_quick_view_admin_url    =   admin_url( 'admin-ajax.php' );
	$basictheme_woo_quick_view_ajax         =   array( 'url' => $basictheme_woo_quick_view_admin_url );

	wp_localize_script( 'woo-quick-view', 'woo_quick_view_product', $basictheme_woo_quick_view_ajax );
}