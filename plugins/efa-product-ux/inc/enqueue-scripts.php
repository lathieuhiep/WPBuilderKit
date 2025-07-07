<?php

use EFA_Product_UX\Swatches\EFA_Swatches_DB;

if ( ! defined( 'ABSPATH' ) ) exit;

// load backend assets
add_action('admin_enqueue_scripts', function () {
    $screen = get_current_screen();

    if ( ! $screen || empty($screen->taxonomy) || ! taxonomy_is_product_attribute($screen->taxonomy) ) {
        return;
    }

    $attribute_tax_name = str_replace('pa_', '', $screen->taxonomy);
    $attribute_id = wc_attribute_taxonomy_id_by_name($screen->taxonomy);

    if ( ! $attribute_id ) return;

    $display_type = EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id);

    if ( $display_type === 'color' ) {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        wp_enqueue_script(
            'efa-admin-color-term',
            EFA_PRODUCT_UX_URL . 'modules/swatches/assets/admin-color-term.js',
            [ 'jquery' ],
            EFA_PRODUCT_UX_VERSION,
            true
        );
    }
});

// load frontend assets
add_action( 'wp_enqueue_scripts', 'efa_product_ux_enqueue_global_assets' );

function efa_product_ux_enqueue_global_assets(): void {
    // Load global CSS (nếu có)
    wp_enqueue_style(
        'efa-product-ux',
        EFA_PRODUCT_UX_URL . 'assets/css/efa-product-ux.css',
        [],
        EFA_PRODUCT_UX_VERSION
    );

    // Load global JS (nếu có)
    wp_enqueue_script(
        'efa-product-ux',
        EFA_PRODUCT_UX_URL . 'assets/js/efa-product-ux.js',
        [ 'jquery' ],
        EFA_PRODUCT_UX_VERSION,
        true
    );
}