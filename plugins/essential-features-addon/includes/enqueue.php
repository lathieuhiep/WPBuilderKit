<?php
// register scripts
add_action( 'wp_enqueue_scripts', 'efa_elementor_script_libs' );
function efa_elementor_script_libs (): void {
	$efa_check_elementor = efa_check_elementor_builder();

	if ( $efa_check_elementor == 'builder' ) {
		// js plugin
		wp_register_script( 'efa-elementor-script', EFA_PLUGIN_URL . 'assets/js/efa-elementor.min.js', array( 'jquery', 'swiper' ), EFA_PLUGIN_VERSION, true );
	}
}

add_action( 'wp_enqueue_scripts', 'efa_elementor_scripts',21 );
function efa_elementor_scripts(): void {
	$efa_check_elementor = efa_check_elementor_builder();

	if ( $efa_check_elementor == 'builder' ) {
		// style plugin
		wp_enqueue_style( 'efa-elementor-style', EFA_PLUGIN_URL . 'assets/css/efa-elementor.min.css', array(), EFA_PLUGIN_VERSION );
	}
}