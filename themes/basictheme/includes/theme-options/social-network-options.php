<?php
// Create a section social network
$max_social_networks = count( basictheme_list_social_network() );

CSF::createSection( PREFIX_THEME_OPTIONS, array(
	'title'  => esc_html__( 'Mạng xã hội', 'basictheme' ),
	'icon'   => 'fab fa-hive',
	'fields' => array(
		array(
			'id'      => 'opt_social_networks',
			'type'    => 'repeater',
			'title'   => esc_html__( 'Mạng xã hội', 'basictheme' ),
			'max'     => $max_social_networks,
			'fields'  => array(
				array(
					'id'          => 'item',
					'type'        => 'select',
					'title'       => esc_html__( 'Chọn mạng xã hội', 'basictheme' ),
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
					'item' => 'facebook-f',
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