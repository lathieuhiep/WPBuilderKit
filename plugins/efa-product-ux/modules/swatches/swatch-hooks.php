<?php
// Xóa metadata swatch khi xóa 1 term
use EFA_Product_UX\Swatches\EFA_Swatches_DB;

add_action('delete_term', function ($term_id, $tt_id, $taxonomy) {
    if (!taxonomy_is_product_attribute($taxonomy)) return;

    EFA_Swatches_DB::delete_swatches_term_meta($term_id);
}, 10, 3);

// Xóa toàn bộ khi xóa attribute 'pa_color'
add_action('woocommerce_attribute_deleted', function ($attribute_id, $attribute_name, $taxonomy) {
    if (!taxonomy_is_product_attribute($taxonomy)) return;

    EFA_Swatches_DB::delete_swatches_by_attribute($attribute_id);
}, 10, 3);