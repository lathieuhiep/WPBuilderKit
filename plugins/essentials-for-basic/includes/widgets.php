<?php
// Register widgets
add_action( 'elementor/widgets/register', 'efb_register_widget_elementor_addon' );
function efb_register_widget_elementor_addon( $widgets_manager ): void {
	// include add on
	require_once EFB_PLUGIN_PATH . 'includes/widgets/about-text.php';
	require_once EFB_PLUGIN_PATH . 'includes/widgets/carousel-images.php';
	require_once EFB_PLUGIN_PATH . 'includes/widgets/contact-form-7.php';
	require_once EFB_PLUGIN_PATH . 'includes/widgets/info-box.php';
	require_once EFB_PLUGIN_PATH . 'includes/widgets/post-carousel.php';
	require_once EFB_PLUGIN_PATH . 'includes/widgets/post-grid.php';
	require_once EFB_PLUGIN_PATH . 'includes/widgets/slides.php';
	require_once EFB_PLUGIN_PATH . 'includes/widgets/testimonial-slider.php';

	// register add on
	$widgets_manager->register( new \EFB_Widget_About_Text() );
	$widgets_manager->register( new \EFB_Widget_Carousel_Images() );
	$widgets_manager->register( new \EFB_Widget_Contact_Form_7() );
	$widgets_manager->register( new \EFB_Widget_Info_Box() );
	$widgets_manager->register( new \EFB_Widget_Post_Carousel() );
	$widgets_manager->register( new \EFB_Widget_Post_Grid() );
	$widgets_manager->register( new \EFB_Widget_Slides() );
	$widgets_manager->register( new \EFB_Widget_Testimonial_Slider() );
}