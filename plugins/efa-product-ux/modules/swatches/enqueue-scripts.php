<?php
// Exit if accessed directly
use EFA_Product_UX\Swatches\EFA_Swatches_DB;

if ( ! defined( 'ABSPATH' ) ) exit;

// load backend assets
add_action('admin_enqueue_scripts', function () {
    $screen = get_current_screen();

    //
    if ( $screen->id === 'product_page_product_attributes' ) {
        wp_enqueue_script(
            'efa-admin-attribute',
            EFA_PRODUCT_UX_URL . 'modules/swatches/assets/admin/attribute.js',
            [ 'jquery' ],
            EFA_PRODUCT_UX_VERSION,
            true
        );
    }

    if ( ! $screen || empty($screen->taxonomy) || ! taxonomy_is_product_attribute($screen->taxonomy) ) {
        return;
    }

    $attribute_id = wc_attribute_taxonomy_id_by_name($screen->taxonomy);

    if ( ! $attribute_id ) return;

    $display_type = EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id);

    if ( $display_type === 'color' ) {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }

    if ($display_type === 'image') {
        wp_enqueue_media();
    }

    if ( $display_type === 'color' || $display_type === 'image' ) {
        wp_enqueue_script(
            'efa-admin-swatches-term',
            EFA_PRODUCT_UX_URL . 'modules/swatches/assets/admin/swatches-term.js',
            [ 'jquery' ],
            EFA_PRODUCT_UX_VERSION,
            true
        );
    }
});

// load frontend assets
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'efa-swatch-css',
        EFA_PRODUCT_UX_URL . 'modules/swatches/assets/user/swatches.css',
        [],
        EFA_PRODUCT_UX_VERSION
    );

    wp_enqueue_script(
        'efa-swatch-js',
        EFA_PRODUCT_UX_URL . 'modules/swatches/assets/user/swatches.js',
        [ 'jquery' ],
        EFA_PRODUCT_UX_VERSION,
        true
    );
} );