<?php
global $prefix_theme_options;

//
//  Create a section shop
CSF::createSection( $prefix_theme_options, array(
	'id'    => 'opt_shop_section',
	'title' => esc_html__( 'Của hàng', 'basictheme' ),
	'icon'  => 'fas fa-shopping-cart',
) );

// Category product
CSF::createSection( $prefix_theme_options, array(
	'parent'      => 'opt_shop_section',
	'title'       => esc_html__( 'Danh mục', 'basictheme' ),
	'description' => esc_html__( 'Sử dụng cho danh mục và thẻ cửa hàng', 'basictheme' ),
	'fields'      => array(
		// Sidebar
		array(
			'id'      => 'opt_shop_cat_sidebar_position',
			'type'    => 'select',
			'title'   => esc_html__( 'Vị trí sidebar', 'basictheme' ),
			'options' => array(
				'hide'  => esc_html__( 'Ẩn', 'basictheme' ),
				'left'  => esc_html__( 'Trái', 'basictheme' ),
				'right' => esc_html__( 'Phải', 'basictheme' ),
			),
			'default' => 'left'
		),

		// Limit
		array(
			'id'      => 'opt_shop_cat_limit',
			'type'    => 'number',
			'title'   => esc_html__( 'Số lượng sản phẩm hiển thị', 'basictheme' ),
			'default' => 12,
		),

		// Per Row
		array(
			'id'      => 'opt_shop_cat_per_row',
			'type'    => 'select',
			'title'   => esc_html__( 'Số sản phẩm trên một hàng', 'basictheme' ),
			'options' => array(
				'3' => esc_html__( '3', 'basictheme' ),
				'4' => esc_html__( '4', 'basictheme' ),
				'5' => esc_html__( '5', 'basictheme' ),
			),
			'default' => '3'
		),
	)
) );

// Single product
CSF::createSection( $prefix_theme_options, array(
	'parent'      => 'opt_shop_section',
	'title'       => esc_html__( 'Chi tiết', 'basictheme' ),
	'description' => esc_html__( 'Sử dụng cho chi tiết sản phẩm', 'basictheme' ),
	'fields'      => array(
		// Sidebar
		array(
			'id'      => 'opt_shop_single_sidebar_position',
			'type'    => 'select',
			'title'   => esc_html__( 'Vị trí sidebar', 'basictheme' ),
			'options' => array(
				'hide'  => esc_html__( 'Ẩn', 'basictheme' ),
				'left'  => esc_html__( 'Trái', 'basictheme' ),
				'right' => esc_html__( 'Phải', 'basictheme' ),
			),
			'default' => 'left'
		)
	)
) );