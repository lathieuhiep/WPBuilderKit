<?php
//
//  Create a section shop
CSF::createSection( PREFIX_THEME_OPTIONS, array(
	'id'    => 'opt_shop_section',
	'title' => esc_html__( 'Của hàng', 'basictheme' ),
	'icon'  => 'fas fa-shopping-cart',
) );

// Category product
CSF::createSection( PREFIX_THEME_OPTIONS, array(
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
            'id' => 'opt_shop_cat_per_row',
            'type' => 'fieldset',
            'title' => esc_html__('Số sản phẩm trên một hàng', 'basictheme'),
            'fields' => basictheme_column_width_fields(1, 4, 1, 2, 3, 3),
        ),
	)
) );

// Single product
CSF::createSection( PREFIX_THEME_OPTIONS, array(
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
		),

        // heading related
        array(
            'type'    => 'heading',
            'content' => esc_html__('Sản phẩm liên quan', 'basictheme'),
        ),

        // Limit related
		array(
            'id'      => 'opt_shop_single_related_limit',
            'type'    => 'number',
            'title'   => esc_html__( 'Số lượng sản phẩm hiển thị', 'basictheme' ),
            'default' => 3,
        ),

        // Per Row related
        array(
            'id' => 'opt_shop_single_related_per_row',
            'type' => 'fieldset',
            'title' => esc_html__('Số sản phẩm trên một hàng', 'basictheme'),
            'fields' => basictheme_column_width_fields(1, 4, 1, 2, 3, 3),
        ),
	)
) );