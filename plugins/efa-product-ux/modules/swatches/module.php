<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// backend
if (is_admin()) {
    require_once EFA_PRODUCT_UX_PATH . 'modules/swatches/inc/back-end/swatch-functions.php';
    require_once EFA_PRODUCT_UX_PATH . '/modules/swatches/inc/back-end/admin-ui.php';
    require_once EFA_PRODUCT_UX_PATH . '/modules/swatches/inc/back-end/color-terms.php';
    require_once EFA_PRODUCT_UX_PATH . '/modules/swatches/inc/back-end/image-terms.php';
    require_once EFA_PRODUCT_UX_PATH . 'modules/swatches/inc/back-end/swatch-hooks.php';
}

// frontend
require_once EFA_PRODUCT_UX_PATH . '/modules/swatches/enqueue-scripts.php';
require_once EFA_PRODUCT_UX_PATH . '/modules/swatches/render.php';