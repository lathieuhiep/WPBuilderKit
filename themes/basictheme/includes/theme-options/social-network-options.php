<?php
global $prefix_theme_options;

// Create a section social network
CSF::createSection( $prefix_theme_options, array(
	'title'  => esc_html__( 'Mạng xã hội', 'basictheme' ),
	'icon'   => 'fab fa-hive',
	'fields' => array(
		array(
			'id'      => 'opt_social_network',
			'type'    => 'repeater',
			'title'   => esc_html__( 'Mạng xã hội', 'basictheme' ),
			'fields'  => array(
				array(
					'id'      => 'icon',
					'type'    => 'icon',
					'title'   => esc_html__( 'Icon', 'basictheme' ),
					'default' => 'fab fa-facebook-f'
				),

				array(
					'id'      => 'url',
					'type'    => 'text',
					'title'   => esc_html__( 'URL', 'basictheme' ),
					'default' => '#'
				),
			),
			'default' => array(
				array(
					'icon' => 'fab fa-facebook-f',
					'url'  => '#',
				),

				array(
					'icon' => 'fab fa-youtube',
					'url'  => '#',
				),
			)
		),
	)
) );
