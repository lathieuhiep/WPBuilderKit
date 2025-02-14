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
	$facebook_url = esc_url( 'https://www.facebook.com/lathieuhiep' );

	// Set a unique slug-like ID
	$prefix_theme_options   = 'options';
	$menu_title = esc_html__( 'Cài đặt theme', 'basictheme' );

	// Create options
	CSF::createOptions( $prefix_theme_options, array(
		'menu_title'          => $menu_title,
		'menu_slug'           => 'theme-options',
		'menu_position'       => 2,
		'admin_bar_menu_icon' => 'dashicons-admin-generic',
		'framework_title'     => $menu_title,
		'footer_text'         => esc_html__( 'Cảm ơn bạn đã sử dụng theme của tôi', 'basictheme' ),
		'footer_after'        => sprintf(
			'<pre>Liên hệ:<br />Zalo/Phone: 0975458209 - Skype: lathieuhiep - facebook: <a href="%s" target="_blank">lathieuhiep</a></pre>',
			$facebook_url
		),
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