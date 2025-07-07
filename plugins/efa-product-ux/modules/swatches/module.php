<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// backend
if (is_admin()) {
    require_once EFA_PRODUCT_UX_PATH . '/modules/swatches/admin-ui.php';
    require_once EFA_PRODUCT_UX_PATH . '/modules/swatches/color-terms.php';
    require_once EFA_PRODUCT_UX_PATH . '/modules/swatches/image-terms.php';
    require_once EFA_PRODUCT_UX_PATH . 'modules/swatches/swatch-hooks.php';
}

// frontend
require_once EFA_PRODUCT_UX_PATH . '/modules/swatches/enqueue-scripts.php';
require_once EFA_PRODUCT_UX_PATH . '/modules/swatches/render.php';