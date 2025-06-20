<?php
//
// -> Create a section blog (parent)
CSF::createSection( PREFIX_THEME_OPTIONS, array(
	'id'    => 'opt_post_section',
	'icon'  => 'fas fa-blog',
	'title' => esc_html__( 'Bài viết', 'basictheme' ),
) );

// Category Post
CSF::createSection( PREFIX_THEME_OPTIONS, array(
	'parent'      => 'opt_post_section',
	'title'       => esc_html__( 'Danh mục', 'basictheme' ),
	'description' => esc_html__( 'Sử dụng cho các trang archive, index, tìm kiếm', 'basictheme' ),
	'fields'      => array(
		// Sidebar
		array(
			'id'      => 'opt_post_cat_sidebar_position',
			'type'    => 'select',
			'title'   => esc_html__( 'Vị trí sidebar', 'basictheme' ),
			'options' => array(
				'hide'  => esc_html__( 'Ẩn', 'basictheme' ),
				'left'  => esc_html__( 'Trái', 'basictheme' ),
				'right' => esc_html__( 'Phải', 'basictheme' ),
			),
			'default' => 'right'
		),

		// Per Row
		array(
			'id'      => 'opt_post_cat_per_row',
			'type'    => 'select',
			'title'   => esc_html__( 'Số bài viết trên mỗi hàng', 'basictheme' ),
			'options' => array(
				'3' => esc_html__( '3', 'basictheme' ),
				'4' => esc_html__( '4', 'basictheme' ),
			),
			'default' => '3'
		),
	)
) );

// Single Post
CSF::createSection( PREFIX_THEME_OPTIONS, array(
	'parent' => 'opt_post_section',
	'title'  => esc_html__( 'Bài viết chi tiết', 'basictheme' ),
	'fields' => array(
		array(
			'id'      => 'opt_post_single_sidebar_position',
			'type'    => 'select',
			'title'   => esc_html__( 'Vị trí sidebar', 'basictheme' ),
			'options' => array(
				'hide'  => esc_html__( 'Ẩn', 'basictheme' ),
				'left'  => esc_html__( 'Trái', 'basictheme' ),
				'right' => esc_html__( 'Phải', 'basictheme' ),
			),
			'default' => 'right'
		),

		// Show related post
		array(
			'id'         => 'opt_post_single_related',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Hiện thị bài viết liên quan', 'basictheme' ),
			'text_on'    => esc_html__( 'Có', 'basictheme' ),
			'text_off'   => esc_html__( 'Không', 'basictheme' ),
			'default'    => true,
			'text_width' => 80
		),

		// Limit related post
		array(
			'id'      => 'opt_post_single_related_limit',
			'type'    => 'number',
			'title'   => esc_html__( 'Số lượng bài viết liên quan', 'basictheme' ),
			'default' => 3,
		),
	)
) );