<?php

use Elementor\Controls_Manager;

function efa_add_image_size_control( $widget, $control_id = 'image_size', $default = 'large', $args = [] ): void {
	$base_args = [
		'label'       => esc_html__( 'Độ phân giải ảnh', 'essential-features-addon' ),
		'type'        => Controls_Manager::SELECT,
		'default'     => $default,
		'options'     => efa_image_size_options(),
		'label_block' => true,
	];

	$widget->add_control( $control_id, array_merge( $base_args, $args ) );
}