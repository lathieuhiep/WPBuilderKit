<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require get_theme_file_path( '/includes/theme-options/helper-options.php' );

// Control core classes for avoid errors
function basictheme_register_theme_options(): void
{
    if ( is_admin() && class_exists( 'CSF' ) ) {
        $facebook_url = esc_url( 'https://www.facebook.com/lathieuhiep' );

        // Set a unique slug-like ID
        $menu_title = esc_html__( 'Cài đặt theme', 'basictheme' );

        // Create options
        CSF::createOptions( PREFIX_THEME_OPTIONS, array(
            'menu_title'          => $menu_title,
            'menu_slug'           => 'theme-options',
            'menu_position'       => 2,
            'admin_bar_menu_icon' => 'dashicons-admin-generic',
            'framework_title'     => $menu_title,
            'footer_text'         => esc_html__( 'Cảm ơn bạn đã sử dụng theme của tôi', 'basictheme' ),
            'footer_after'        => sprintf(
                '<pre>Liên hệ:<br />Zalo/Phone: 0975458209 - facebook: <a href="%s" target="_blank">lathieuhiep</a></pre>',
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
        if ( class_exists( 'Woocommerce' ) ) :
            require get_theme_file_path( '/includes/theme-options/shop-options.php' );
        endif;

        // footer options
        require get_theme_file_path( '/includes/theme-options/footer-options.php' );

        // custom code options
        require get_theme_file_path( '/includes/theme-options/custom-code-options.php' );
    }
}
add_action( 'after_setup_theme', 'basictheme_register_theme_options' );