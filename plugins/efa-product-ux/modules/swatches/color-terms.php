<?php
use EFA_Product_UX\Swatches\EFA_Swatches_DB;

add_action('woocommerce_init', 'efa_register_color_term_hooks');

function efa_register_color_term_hooks(): void
{
    add_action('current_screen', function () {
        $screen = get_current_screen();
        if (!$screen || !isset($screen->taxonomy)) return;

        $taxonomy = $screen->taxonomy;
        if (!str_starts_with($taxonomy, 'pa_')) return;

        $attribute_id = EFA_Swatches_DB::get_attribute_id_by_taxonomy($taxonomy);
        if (!$attribute_id) return;

        if (EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id) !== 'color') return;

        // Thêm field khi tạo
        add_action("{$taxonomy}_add_form_fields", function () use ($attribute_id) {
            ?>
            <div class="form-field">
                <label for="term_color">Chọn màu</label>
                <input type="text" name="term_color" id="term_color" value="" class="colorpicker" />
            </div>
            <script>jQuery(function($){ $('.colorpicker').wpColorPicker(); });</script>
            <?php
        });

        // Thêm field khi sửa
        add_action("{$taxonomy}_edit_form_fields", function ($term) use ($attribute_id) {
            $color = EFA_Swatches_DB::get_swatches_term_meta($term->term_id, 'color');
            ?>
            <tr class="form-field">
                <th scope="row"><label for="term_color">Chọn màu</label></th>
                <td>
                    <input type="text" name="term_color" id="term_color" value="<?php echo esc_attr($color); ?>" class="colorpicker" />
                </td>
            </tr>
            <script>jQuery(function($){ $('.colorpicker').wpColorPicker(); });</script>
            <?php
        });

        // Hiển thị cột màu trong danh sách
        add_filter("manage_edit-{$taxonomy}_columns", function ($columns) {
            $new_columns = [];

            foreach ($columns as $key => $value) {
                if ($key === 'posts') {
                    // Chèn cột 'color' trước cột 'posts'
                    $new_columns['color'] = 'Mã màu';
                }

                $new_columns[$key] = $value;
            }

            return $new_columns;
        });


        add_filter("manage_{$taxonomy}_custom_column", function ($out, $column, $term_id) use ($attribute_id) {
            if ($column === 'color') {
                $color = EFA_Swatches_DB::get_swatches_term_meta($term_id, 'color');
                if ($color) {
                    $out = sprintf(
                        '<div style="display:flex;align-items:center;gap:6px">
                            <div style="width:24px;height:24px;border:1px solid #ccc;background:%1$s;"></div>
                            <span style="font-family:monospace;">%1$s</span>
                        </div>',
                        esc_attr($color)
                    );
                }
            }
            return $out;
        }, 10, 3);
    });

    // Lưu khi chỉnh sửa term
    add_action('admin_init', function () {
        if (!is_admin() || empty($_POST['taxonomy']) || empty($_POST['term_color'])) return;

        $taxonomy = $_POST['taxonomy'];
        if (!str_starts_with($taxonomy, 'pa_')) return;

        $term_id = intval($_POST['tag_ID'] ?? 0);
        if ($term_id <= 0) return;

        $attribute_id = EFA_Swatches_DB::get_attribute_id_by_taxonomy($taxonomy);
        if (!$attribute_id) return;

        if (EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id) !== 'color') return;

        $color = sanitize_hex_color($_POST['term_color']);
        EFA_Swatches_DB::save_swatches_term_meta($term_id, $attribute_id, 'color', $color);
    });

    // Lưu khi tạo mới term
    add_action('created_term', function ($term_id, $tt_id, $taxonomy) {
        if (!str_starts_with($taxonomy, 'pa_')) return;
        if (empty($_POST['term_color'])) return;

        $attribute_id = EFA_Swatches_DB::get_attribute_id_by_taxonomy($taxonomy);
        if (!$attribute_id) return;

        if (EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id) !== 'color') return;

        $color = sanitize_hex_color($_POST['term_color']);
        EFA_Swatches_DB::save_swatches_term_meta($term_id, $attribute_id, 'color', $color);
    }, 10, 3);
}

add_action('wp_ajax_efa_delete_term_meta_by_term_id', function () {
    $term_id = absint($_POST['term_id'] ?? 0);
    $taxonomy = sanitize_text_field($_POST['taxonomy'] ?? '');

    if (!$term_id || !taxonomy_is_product_attribute($taxonomy)) {
        wp_send_json_error(['msg' => 'Term ID hoặc taxonomy không hợp lệ']);
    }

    EFA_Swatches_DB::delete_swatches_term_meta($term_id);

    wp_send_json_success(['msg' => 'Đã xoá metadata']);
});
