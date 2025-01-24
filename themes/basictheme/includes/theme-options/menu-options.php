<?php
global $prefix_theme_options;

// Create a section menu
CSF::createSection( $prefix_theme_options, array(
	'title'  => esc_html__( 'Menu', 'basictheme' ),
	'icon'   => 'fas fa-bars',
	'fields' => array(
		// Sticky menu
		array(
			'id'         => 'opt_menu_sticky',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Menu cố định', 'basictheme' ),
			'text_on'    => esc_html__( 'Có', 'basictheme' ),
			'text_off'   => esc_html__( 'Không', 'basictheme' ),
			'text_width' => 80,
			'default'    => true
		),

		// Show cart
		array(
			'id'         => 'opt_menu_cart',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Hiện thị giỏ hàng trên menu', 'basictheme' ),
			'text_on'    => esc_html__( 'Có', 'basictheme' ),
			'text_off'   => esc_html__( 'Không', 'basictheme' ),
			'text_width' => 80,
			'default'    => true
		),
	)
) );