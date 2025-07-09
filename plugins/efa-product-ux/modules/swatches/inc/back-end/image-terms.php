<?php
use EFA_Product_UX\Swatches\EFA_Swatches_DB;

add_action('woocommerce_init', 'efa_register_image_term_hooks');

function efa_register_image_term_hooks(): void
{
    add_action('current_screen', function () {
        $screen = get_current_screen();
        if (!$screen || !isset($screen->taxonomy)) return;

        $taxonomy = $screen->taxonomy;
        if (!str_starts_with($taxonomy, 'pa_')) return;

        $attribute_id = EFA_Swatches_DB::get_attribute_id_by_taxonomy($taxonomy);
        if (!$attribute_id) return;

        if (EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id) !== 'image') return;

        // Thêm field khi tạo
        add_action("{$taxonomy}_add_form_fields", function () {
            ?>
            <div class="form-field">
                <label for="term_image">Ảnh swatch</label>
                <button type="button" class="button efa-upload-image">Chọn ảnh</button>
                <input type="hidden" name="term_image" id="term_image" value="" />
                <div class="efa-image-preview" style="margin-top:10px;"></div>
            </div>
            <?php
        });

        // Thêm field khi sửa
        add_action("{$taxonomy}_edit_form_fields", function ($term) use ($attribute_id) {
            $image_id = EFA_Swatches_DB::get_swatches_term_meta($term->term_id, 'image');
            $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';
            ?>
            <tr class="form-field">
                <th scope="row"><label for="term_image">Ảnh swatch</label></th>
                <td>
                    <button type="button" class="button efa-upload-image">Chọn ảnh</button>
                    <input type="hidden" name="term_image" id="term_image" value="<?php echo esc_attr($image_id); ?>" />
                    <div class="efa-image-preview" style="margin-top:10px;">
                        <?php if ($image_url): ?>
                            <img width="150" height="150" src="<?php echo esc_url($image_url); ?>" style="max-width: 100%" alt=""/>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php
        });

        // Cột ảnh
        add_filter("manage_edit-{$taxonomy}_columns", function ($columns) {
            $new_columns = [];

            foreach ($columns as $key => $value) {
                if ($key === 'posts') {
                    $new_columns['image'] = 'Ảnh';
                }
                $new_columns[$key] = $value;
            }

            return $new_columns;
        });

        add_filter("manage_{$taxonomy}_custom_column", function ($out, $column, $term_id) use ($attribute_id) {
            if ($column === 'image') {
                $id = EFA_Swatches_DB::get_swatches_term_meta($term_id, 'image');
                if ($id) {
                    $out = wp_get_attachment_image($id, 'thumbnail', false, ['style' => 'width:50px; height: auto']);
                }
            }
            return $out;
        }, 10, 3);
    });

    // Lưu khi sửa
    add_action('admin_init', function () {
        if (!is_admin() || empty($_POST['taxonomy']) || empty($_POST['term_image'])) return;

        $taxonomy = $_POST['taxonomy'];
        if (!str_starts_with($taxonomy, 'pa_')) return;

        $term_id = intval($_POST['tag_ID'] ?? 0);
        if ($term_id <= 0) return;

        $attribute_id = EFA_Swatches_DB::get_attribute_id_by_taxonomy($taxonomy);
        if (!$attribute_id) return;

        if (EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id) !== 'image') return;

        $image_id = absint($_POST['term_image']);
        EFA_Swatches_DB::save_swatches_term_meta($term_id, $attribute_id, 'image', $image_id);
    });

    // Lưu khi tạo mới
    add_action('created_term', function ($term_id, $tt_id, $taxonomy) {
        if (!str_starts_with($taxonomy, 'pa_')) return;
        if (empty($_POST['term_image'])) return;

        $attribute_id = EFA_Swatches_DB::get_attribute_id_by_taxonomy($taxonomy);
        if (!$attribute_id) return;

        if (EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id) !== 'image') return;

        $image_id = absint($_POST['term_image']);
        EFA_Swatches_DB::save_swatches_term_meta($term_id, $attribute_id, 'image', $image_id);
    }, 10, 3);
}