<?php
// Register widgets
add_action( 'elementor/widgets/register', 'efa_register_widget_elementor_addon' );
function efa_register_widget_elementor_addon( $widgets_manager ): void {
	// include add on
	require_once EFA_PLUGIN_PATH . 'includes/widgets/carousel-images.php';
	require_once EFA_PLUGIN_PATH . 'includes/widgets/contact-form-7.php';
	require_once EFA_PLUGIN_PATH . 'includes/widgets/heading-with-editor.php';
	require_once EFA_PLUGIN_PATH . 'includes/widgets/info-box.php';
	require_once EFA_PLUGIN_PATH . 'includes/widgets/post-carousel.php';
	require_once EFA_PLUGIN_PATH . 'includes/widgets/post-grid.php';
	require_once EFA_PLUGIN_PATH . 'includes/widgets/slides.php';
	require_once EFA_PLUGIN_PATH . 'includes/widgets/testimonial-slider.php';

	// register add on
	$widgets_manager->register( new \EFA_Widget_Carousel_Images() );
	$widgets_manager->register( new \EFA_Widget_Contact_Form_7() );
	$widgets_manager->register( new \EFA_Widget_Heading_With_Editor() );
	$widgets_manager->register( new \EFA_Widget_Info_Box() );
	$widgets_manager->register( new \EFA_Widget_Post_Carousel() );
	$widgets_manager->register( new \EFA_Widget_Post_Grid() );
	$widgets_manager->register( new \EFA_Widget_Slides() );
	$widgets_manager->register( new \EFA_Widget_Testimonial_Slider() );
}