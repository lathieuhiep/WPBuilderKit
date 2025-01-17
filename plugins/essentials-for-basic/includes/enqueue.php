<?php
// Register scripts
add_action( 'wp_enqueue_scripts', 'efb_elementor_scripts' );
function efb_elementor_scripts(): void {
	$efb_check_elementor = get_post_meta( get_the_ID(), '_elementor_edit_mode', true );

	if ( $efb_check_elementor == 'builder' ) {
		// style
		wp_enqueue_style( 'owl.carousel', get_theme_file_uri( '/assets/libs/owl.carousel/owl.carousel.min.css' ), array(), '2.3.4' );

		wp_enqueue_style( 'efb-style', EFB_PLUGIN_URL . 'assets/css/addons.min.css', array(), EFB_PLUGIN_VERSION );

		// js
		wp_enqueue_script( 'owl.carousel', get_theme_file_uri( '/assets/libs/owl.carousel/owl.carousel.min.js' ), array( 'jquery' ), '2.3.4', true );

		wp_enqueue_script( 'efb-script', EFB_PLUGIN_URL . 'assets/js/elementor-addon.min.js', array( 'jquery' ), EFB_PLUGIN_VERSION, true );
	}
}