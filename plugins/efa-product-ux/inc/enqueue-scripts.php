<?php
if ( ! defined( 'ABSPATH' ) ) exit;

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