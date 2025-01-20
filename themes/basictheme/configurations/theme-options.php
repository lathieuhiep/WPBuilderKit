<?php
// A Custom function for get an option
if ( ! function_exists( 'basictheme_get_option' ) ) {
	function basictheme_get_option( $option = '', $default = null ) {
		$options = get_option( 'options' );

		return ( isset( $options[ $option ] ) ) ? $options[ $option ] : $default;
	}
}

// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {
// Set a unique slug-like ID
	$basictheme_prefix   = 'options';
	$basictheme_my_theme = wp_get_theme();

	// Create options
	CSF::createOptions( $basictheme_prefix, array(
		'menu_title'          => esc_html__( 'Cài đặt theme', 'basictheme' ),
		'menu_slug'           => 'theme-options',
		'menu_position'       => 2,
		'admin_bar_menu_icon' => 'dashicons-admin-generic',
		'framework_title'     => $basictheme_my_theme->get('Name') . ' theme-options.php' . esc_html__( 'Options', 'basictheme' ),
		'footer_text'         => esc_html__( 'Cảm ơn bạn đã sử dụng theme của tôi', 'basictheme' ),
		'footer_after'        => '<pre>Liên hệ:<br />Zalo/Phone: 0975458209 - Skype: lathieuhiep - facebook: <a href="https://www.facebook.com/lathieuhiep" target="_blank">lathieuhiep</a></pre>',
	) );

	// Create a section general
	CSF::createSection( $basictheme_prefix, array(
		'title'  => esc_html__( 'General', 'basictheme' ),
		'icon'   => 'fas fa-cog',
		'fields' => array(
			// favicon
			array(
				'id'      => 'opt_general_favicon',
				'type'    => 'media',
				'title'   => esc_html__( 'Chọn ảnh favicon', 'basictheme' ),
				'library' => 'image',
				'url'     => false
			),

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
				'subtitle'   => esc_html__( 'Sử dụng ảnh .git', 'basictheme' ) . ' <a href="https://loading.io/" target="_blank">loading.io</a>',
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

	//
	// Create a section menu
	CSF::createSection( $basictheme_prefix, array(
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

	//
	// -> Create a section blog
	CSF::createSection( $basictheme_prefix, array(
		'id'    => 'opt_post_section',
		'icon'  => 'fas fa-blog',
		'title' => esc_html__( 'Bài viết', 'basictheme' ),
	) );

	// Category Post
	CSF::createSection( $basictheme_prefix, array(
		'parent' => 'opt_post_section',
		'title'  => esc_html__( 'Danh mục', 'basictheme' ),
		'description' => esc_html__( 'Sử dụng cho các trang archive, index, tìm kiếm', 'basictheme' ),
		'fields' => array(
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
	CSF::createSection( $basictheme_prefix, array(
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

	//
	// Create a section social network
	CSF::createSection( $basictheme_prefix, array(
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
						'id'    => 'url',
						'type'  => 'text',
						'title' => esc_html__('URL', 'basictheme'),
						'default' => '#'
					),
				),
				'default' => array(
					array(
						'icon' => 'fab fa-facebook-f',
						'url' => '#',
					),

					array(
						'icon' => 'fab fa-youtube',
						'url' => '#',
					),
				)
			),
		)
	) );

	//
	//  Create a section shop
	CSF::createSection( $basictheme_prefix, array(
		'id'    => 'opt_shop_section',
		'title'  => esc_html__( 'Của hàng', 'basictheme' ),
		'icon'   => 'fas fa-shopping-cart',
	) );

	// Category product
	CSF::createSection( $basictheme_prefix, array(
		'parent' => 'opt_shop_section',
		'title'  => esc_html__( 'Danh mục', 'basictheme' ),
		'description' => esc_html__( 'Sử dụng cho danh mục và thẻ cửa hàng', 'basictheme' ),
		'fields' => array(
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
				'default' => '4'
			),
		)
	) );

	// Single product
	CSF::createSection( $basictheme_prefix, array(
		'parent' => 'opt_shop_section',
		'title'  => esc_html__( 'Chi tiết', 'basictheme' ),
		'description' => esc_html__( 'Sử dụng cho chi tiết sản phẩm', 'basictheme' ),
		'fields' => array(
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

	//
	// -> Create a section footer
	CSF::createSection( $basictheme_prefix, array(
		'id'    => 'opt_footer_section',
		'icon'  => 'fas fa-stream',
		'title' => esc_html__( 'Chân trang', 'basictheme' ),
	) );

	// footer columns
	CSF::createSection( $basictheme_prefix, array(
		'parent' => 'opt_footer_section',
		'title'  => esc_html__( 'Cài đặt cột sidebar', 'basictheme' ),
		'fields' => array(
			// select columns
			array(
				'id'      => 'opt_footer_columns',
				'type'    => 'select',
				'title'   => esc_html__( 'Number of footer columns', 'basictheme' ),
				'options' => array(
					'0' => esc_html__( 'Hide', 'basictheme' ),
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
				),
				'default' => '4'
			),

			// column width 1
			array(
				'id'         => 'opt_footer_column_width_1',
				'type'       => 'slider',
				'title'      => esc_html__( 'Độ rộng cột 1', 'basictheme' ),
				'default'    => 3,
				'min'        => 1,
				'max'        => 12,
				'dependency' => array( 'opt_footer_columns', '!=', '0' )
			),

			// column width 2
			array(
				'id'         => 'opt_footer_column_width_2',
				'type'       => 'slider',
				'title'      => esc_html__( 'Độ rộng cột 2', 'basictheme' ),
				'default'    => 3,
				'min'        => 1,
				'max'        => 12,
				'dependency' => array( 'opt_footer_columns', 'not-any', '0,1' )
			),

			// column width 3
			array(
				'id'         => 'opt_footer_column_width_3',
				'type'       => 'slider',
				'title'      => esc_html__( 'Độ rộng cột 3', 'basictheme' ),
				'default'    => 3,
				'min'        => 1,
				'max'        => 12,
				'dependency' => array( 'opt_footer_columns', 'not-any', '0,1,2' )
			),

			// column width 4
			array(
				'id'         => 'opt_footer_column_width_4',
				'type'       => 'slider',
				'title'      => esc_html__( 'Độ rộng cột 4', 'basictheme' ),
				'default'    => 3,
				'min'        => 1,
				'max'        => 12,
				'dependency' => array( 'opt_footer_columns', 'not-any', '0,1,2,3' )
			),
		)
	) );

	// Copyright
	CSF::createSection( $basictheme_prefix, array(
		'parent' => 'opt_footer_section',
		'title'  => esc_html__( 'Copyright', 'basictheme' ),
		'fields' => array(
			// show
			array(
				'id'         => 'opt_footer_copyright_show',
				'type'       => 'switcher',
				'title'      => esc_html__( 'Hiện thị copyright', 'basictheme' ),
				'text_on'    => esc_html__( 'Có', 'basictheme' ),
				'text_off'   => esc_html__( 'Không', 'basictheme' ),
				'text_width' => 80,
				'default'    => true
			),

			// content
			array(
				'id'      => 'opt_footer_copyright_content',
				'type'    => 'wp_editor',
				'title'   => esc_html__( 'Nội dung', 'basictheme' ),
				'media_buttons' => false,
				'default' => esc_html__( 'Copyright &copy; DiepLK', 'basictheme' )
			),
		)
	) );
}