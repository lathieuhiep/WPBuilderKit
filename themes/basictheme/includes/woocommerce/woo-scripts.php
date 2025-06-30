<?php

//Register front end woo
add_action('wp_enqueue_scripts', 'basictheme_register_front_end_woo');

function basictheme_register_front_end_woo(): void
{
    $theme_woo_admin_ajax_url = array(
        'url' => admin_url('admin-ajax.php')
    );
    
    if (is_shop() || is_product_category() || is_product_tag()) {
        // css
        wp_enqueue_style('woo-archive', get_theme_file_uri('/includes/woocommerce/assets/css/woo-archive.min.css'), array(), basictheme_get_version_theme());
    }
    
    if (is_product()) {
        wp_enqueue_style('woo-single', get_theme_file_uri('/includes/woocommerce/assets/css/woo-single.min.css'), array(), basictheme_get_version_theme());

        wp_enqueue_script('woo-single',
            get_theme_file_uri('/includes/woocommerce/assets/js/woo-single.min.js'),
            array('jquery'),
            basictheme_get_version_theme(),
            true
        );
    }

    // include woo main
    if (!is_cart() || is_checkout()) {
        wp_enqueue_script('woo-main',
            get_theme_file_uri('/includes/woocommerce/assets/js/woo-main.min.js'),
            array('jquery'),
            basictheme_get_version_theme(),
            true
        );
    }

    if ( is_shop() || is_product_category() || is_product_tag() || is_product() ) {
        // js
        wp_enqueue_script('woo-archive',
            get_theme_file_uri('/includes/woocommerce/assets/js/woo-archive.min.js'),
            array('jquery', 'wc-add-to-cart-variation'),
            basictheme_get_version_theme(),
            true)
        ;
        wp_localize_script('woo-archive', 'woo_quick_view_product', $theme_woo_admin_ajax_url);
    }
}