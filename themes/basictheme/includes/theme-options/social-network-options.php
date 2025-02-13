<?php
global $prefix_theme_options;

// Create a section social network
CSF::createSection( $prefix_theme_options, array(
	'title'  => esc_html__( 'Mạng xã hội', 'basictheme' ),
	'icon'   => 'fab fa-hive',
	'fields' => array(
		array(
			'id'      => 'opt_social_networks',
			'type'    => 'repeater',
			'title'   => esc_html__( 'Mạng xã hội', 'basictheme' ),
			'fields'  => array(
				array(
					'id'          => 'item',
					'type'        => 'select',
					'title'       => 'Select',
					'placeholder' => esc_html__( '--Chọn mạng xã hội--', 'basictheme' ),
					'options'     => basictheme_list_social_network(),
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
					'item' => 'facebook',
					'url'  => '#',
				),

				array(
					'item' => 'youtube',
					'url'  => '#',
				),
			)
		),
	)
) );
