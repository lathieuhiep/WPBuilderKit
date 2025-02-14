<?php
global $prefix_theme_options;

$link = esc_url( 'https://loading.io/' );
// Create a section general
CSF::createSection( $prefix_theme_options, array(
	'title'  => esc_html__( 'Cài đặt chung', 'basictheme' ),
	'icon'   => 'fas fa-cog',
	'fields' => array(
		// logo
		array(
			'id'      => 'opt_general_logo',
			'type'    => 'media',
			'title'   => esc_html__( 'Chọn ảnh logo', 'basictheme' ),
			'library' => 'image',
			'url'     => false
		),

		// show loading
		array(
			'id'         => 'opt_general_loading',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Hiện tải trang', 'basictheme' ),
			'text_on'    => esc_html__( 'Có', 'basictheme' ),
			'text_off'   => esc_html__( 'Không', 'basictheme' ),
			'text_width' => 80,
			'default'    => false
		),

		array(
			'id'         => 'opt_general_image_loading',
			'type'       => 'media',
			'title'      => esc_html__( 'Chọn ảnh tải trang', 'basictheme' ),
			'subtitle'   => sprintf(
				esc_html__( 'Sử dụng ảnh .git %s', 'basictheme' ),
				'<a href="' . $link . '" target="_blank">loading.io</a>'
			),
			'dependency' => array( 'opt_general_loading', '==', 'true' ),
			'url'        => false
		),

		// show back to top
		array(
			'id'         => 'opt_general_back_to_top',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Hiện nút quay về đầu trang', 'basictheme' ),
			'text_on'    => esc_html__( 'Có', 'basictheme' ),
			'text_off'   => esc_html__( 'Không', 'basictheme' ),
			'text_width' => 80,
			'default'    => true
		),
	)
) );