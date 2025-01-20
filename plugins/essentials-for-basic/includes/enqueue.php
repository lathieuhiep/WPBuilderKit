<?php
// register scripts
add_action( 'wp_enqueue_scripts', 'efb_elementor_register_scripts' );
function efb_elementor_register_scripts (): void {
	$efb_check_elementor = get_post_meta( get_the_ID(), '_elementor_edit_mode', true );

	if ( $efb_check_elementor == 'builder' ) {
		// owl.carousel
		wp_register_style( 'owl.carousel', EFB_PLUGIN_URL . 'assets/libs/owl.carousel/owl.carousel.min.css' );
		wp_register_script('owl.carousel', EFB_PLUGIN_URL . 'assets/libs/owl.carousel/owl.carousel.min.js', array('jquery'), '2.3.4', true);

		// js plugin
		wp_register_script( 'efb-script', EFB_PLUGIN_URL . 'assets/js/elementor-addon.min.js', array( 'jquery' ), EFB_PLUGIN_VERSION, true );
	}
}

add_action( 'wp_enqueue_scripts', 'efb_elementor_scripts',21 );
function efb_elementor_scripts(): void {
	$efb_check_elementor = get_post_meta( get_the_ID(), '_elementor_edit_mode', true );

	if ( $efb_check_elementor == 'builder' ) {
		// style plugin
		wp_enqueue_style( 'efb-style', EFB_PLUGIN_URL . 'assets/css/addons.min.css', array(), EFB_PLUGIN_VERSION );
	}
}