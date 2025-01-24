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
	add_action( 'admin_enqueue_scripts', function () {
		// Hủy Font Awesome 5 mặc định của Codestar Framework
		wp_dequeue_style( 'csf-fa5' );
		wp_dequeue_style( 'csf-fa5-v4-shims' );

		// Thêm Font Awesome 6 vào khu vực admin
		wp_enqueue_style( 'font-awesome-6-admin', get_theme_file_uri( '/assets/libs/fontawesome/css/fontawesome.min.css' ), [], '6.7.2' );
	}, 10 );

	// remove icon
	add_filter( 'csf_field_icon_add_icons', 'customize_csf_icons' );
	function customize_csf_icons( $icons ) {
		foreach ( $icons as $key => $list ) {
			foreach ( $list["icons"] as $icon_key => $icon ) {
				if ( $icon === 'fab fa-acquisitions-incorporated' ) {
					unset( $list['icons'][ $icon_key ] );
					break;
				}
			}

			$icons[ $key ] = $list;
		}

		return $icons;
	}

	// Set a unique slug-like ID
	$prefix_theme_options   = 'options';
	$basictheme_my_theme = wp_get_theme();

	// Create options
	CSF::createOptions( $prefix_theme_options, array(
		'menu_title'          => esc_html__( 'Cài đặt theme', 'basictheme' ),
		'menu_slug'           => 'theme-options',
		'menu_position'       => 2,
		'admin_bar_menu_icon' => 'dashicons-admin-generic',
		'framework_title'     => $basictheme_my_theme->get( 'Name' ) . ' theme-options.php' . esc_html__( 'Options', 'basictheme' ),
		'footer_text'         => esc_html__( 'Cảm ơn bạn đã sử dụng theme của tôi', 'basictheme' ),
		'footer_after'        => '<pre>Liên hệ:<br />Zalo/Phone: 0975458209 - Skype: lathieuhiep - facebook: <a href="https://www.facebook.com/lathieuhiep" target="_blank">lathieuhiep</a></pre>',
	) );

	// general options
	require get_theme_file_path( '/includes/theme-options/general-options.php' );

	// menu options
	require get_theme_file_path( '/includes/theme-options/menu-options.php' );

	// blog options
	require get_theme_file_path( '/includes/theme-options/blog-options.php' );

	// social network options
	require get_theme_file_path( '/includes/theme-options/social-network-options.php' );

	// shop options
	require get_theme_file_path( '/includes/theme-options/shop-options.php' );

	// footer options
	require get_theme_file_path( '/includes/theme-options/footer.php' );
}