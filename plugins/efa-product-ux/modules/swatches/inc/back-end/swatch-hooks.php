<?php
// Xóa metadata swatch khi xóa 1 term
use EFA_Product_UX\Swatches\EFA_Swatches_DB;

// delete term meta
add_action('delete_term', function ($term_id, $tt_id, $taxonomy) {
    if (!taxonomy_is_product_attribute($taxonomy)) return;

    EFA_Swatches_DB::delete_swatches_term_meta($term_id);
}, 10, 3);

// Xóa toàn bộ khi xóa attribute 'pa_color'
add_action('woocommerce_attribute_deleted', function ($attribute_id, $attribute_name, $taxonomy) {
    if (!taxonomy_is_product_attribute($taxonomy)) return;

    EFA_Swatches_DB::delete_swatches_by_attribute($attribute_id);
}, 10, 3);

// delete term meta by term ID via AJAX
add_action('wp_ajax_efa_delete_term_meta_by_term_id', function () {
    $term_id = absint($_POST['term_id'] ?? 0);
    $taxonomy = sanitize_text_field($_POST['taxonomy'] ?? '');

    if (!$term_id || !taxonomy_is_product_attribute($taxonomy)) {
        wp_send_json_error(['msg' => 'Term ID hoặc taxonomy không hợp lệ']);
    }

    EFA_Swatches_DB::delete_swatches_term_meta($term_id);

    wp_send_json_success(['msg' => 'Đã xoá metadata']);
});

//
add_action('wp_ajax_efa_get_attribute_types', 'efa_get_attribute_types');
function efa_get_attribute_types(): void
{
    check_ajax_referer('efa_product_attribute_nonce', 'security');
    wp_send_json_success([
        'attributeList' => EFA_Swatches_DB::get_attributes_with_display_type()
    ]);
}
