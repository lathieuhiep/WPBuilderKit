<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', 'efa_product_ux_enqueue_swatches_assets' );
function efa_product_ux_enqueue_swatches_assets(): void {
    wp_enqueue_style(
        'efa-swatch-css',
        EFA_PRODUCT_UX_URL . 'modules/swatches/assets/swatches.css',
        [],
        EFA_PRODUCT_UX_VERSION
    );

    wp_enqueue_script(
        'efa-swatch-js',
        EFA_PRODUCT_UX_URL . 'modules/swatches/assets/swatches.js',
        [ 'jquery' ],
        EFA_PRODUCT_UX_VERSION,
        true
    );
}