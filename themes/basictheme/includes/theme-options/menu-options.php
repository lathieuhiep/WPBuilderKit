<?php
// Create a section menu
CSF::createSection( PREFIX_THEME_OPTIONS, array(
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
	)
) );