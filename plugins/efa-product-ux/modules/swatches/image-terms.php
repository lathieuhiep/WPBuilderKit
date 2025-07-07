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
                <label for="swatch_image_id">Ảnh swatch</label>
                <div id="image_preview"></div>
                <input type="hidden" id="swatch_image_id" name="swatch_image_id" value="" />
                <button type="button" class="button upload-image-button">Chọn ảnh</button>
            </div>
            <script>
                jQuery(function($){
                    loadEfaImageSwatchUploader($);

                    let selectedImage = null;
                    let selectedImageId = null;

                    // Cập nhật biến khi chọn ảnh
                    $(document).on('attachment-selected', function (_, attachment) {
                        selectedImage = attachment.url;
                        selectedImageId = attachment.id;
                    });

                    $('form#addtag').on('submit', function () {
                        if (!$('#swatch_image_id').val() && selectedImageId) {
                            $('#swatch_image_id').val(selectedImageId);
                        }

                        // Delay để đợi WP thêm xong term mới rồi append ảnh vào dòng cuối
                        setTimeout(function () {
                            const lastRow = $('#the-list > tr').last();
                            if (selectedImage) {
                                lastRow.find('td.column-image').html(`
                                <div style="display:flex;align-items:center;gap:6px">
                                    <img src="${selectedImage}" style="height:32px;width:auto;border:1px solid #ccc;background:#fff;padding:2px;" />
                                    <span style="font-family:monospace;">#${selectedImageId}</span>
                                </div>
                            `);
                            }
                        }, 1200);
                    });
                });
            </script>
            <?php
        });

        // Thêm field khi sửa
        add_action("{$taxonomy}_edit_form_fields", function ($term) use ($attribute_id) {
            $image_id = EFA_Swatches_DB::get_swatches_term_meta($term->term_id, 'image_id');
            $image_url = $image_id ? wp_get_attachment_url($image_id) : '';
            ?>
            <tr class="form-field">
                <th scope="row"><label>Ảnh swatch</label></th>
                <td>
                    <div id="image_preview"><?php if ($image_url) echo '<img src="' . esc_url($image_url) . '" style="max-height:50px;" />'; ?></div>
                    <input type="hidden" id="swatch_image_id" name="swatch_image_id" value="<?php echo esc_attr($image_id); ?>" />
                    <button type="button" class="button upload-image-button">Chọn ảnh</button>
                </td>
            </tr>
            <script>jQuery(function($){ loadEfaImageSwatchUploader($); });</script>
            <?php
        });

        // Hiển thị cột ảnh
        add_filter("manage_edit-{$taxonomy}_columns", function ($columns) {
            $columns['image'] = 'Ảnh';
            return $columns;
        });

        add_filter("manage_{$taxonomy}_custom_column", function ($out, $column, $term_id) use ($taxonomy) {
            if ($column === 'image') {
                $attribute_id = EFA_Swatches_DB::get_attribute_id_by_taxonomy($taxonomy);
                if (!$attribute_id) return $out;
                $image_id = EFA_Swatches_DB::get_swatches_term_meta($term_id, 'image_id');
                $image_url = $image_id ? wp_get_attachment_url($image_id) : '';
                if ($image_url) {
                    $out = sprintf(
                        '<div style="display:flex;align-items:center;gap:6px">
                            <img src="%s" style="height:32px;width:auto;border:1px solid #ccc;background:#fff;padding:2px;" />
                            <span style="font-family:monospace;">#%d</span>
                        </div>',
                        esc_url($image_url),
                        intval($image_id)
                    );
                }
            }
            return $out;
        }, 10, 3);

        // Enqueue uploader
        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_media();
            wp_add_inline_script('jquery', <<<JS
                let frame;
                function loadEfaImageSwatchUploader($){
                    $('.upload-image-button').on('click', function(e){
                        e.preventDefault();
                        if (frame) { frame.open(); return; }
                        frame = wp.media({ title: 'Chọn ảnh', button: { text: 'Chọn ảnh' }, multiple: false });
                        frame.on('select', function(){
                            const attachment = frame.state().get('selection').first().toJSON();
                            $('#swatch_image_id').val(attachment.id);
                            $('#image_preview').html('<img src="'+attachment.url+'" style="max-height:50px;" />');
                            $(document).trigger('attachment-selected', attachment);
                        });
                        frame.open();
                    });
                }
            JS
            );
        });
    });
}

// Lưu ảnh khi chỉnh sửa term
add_action('admin_init', function () {
    if (!is_admin() || empty($_POST['taxonomy']) || empty($_POST['swatch_image_id']) || empty($_POST['tag_ID'])) return;

    $taxonomy = $_POST['taxonomy'];
    if (!str_starts_with($taxonomy, 'pa_')) return;

    $term_id = intval($_POST['tag_ID']);
    if ($term_id <= 0) return;

    $attribute_id = EFA_Swatches_DB::get_attribute_id_by_taxonomy($taxonomy);
    if (!$attribute_id) return;

    if (EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id) !== 'image') return;

    $image_id = intval($_POST['swatch_image_id']);
    EFA_Swatches_DB::save_swatches_term_meta($term_id, $attribute_id, 'image_id', $image_id);
});

// Lưu ảnh khi tạo mới term
add_action('created_term', function ($term_id, $tt_id, $taxonomy) {
    if (!str_starts_with($taxonomy, 'pa_')) return;
    if (empty($_POST['swatch_image_id'])) return;

    $attribute_id = EFA_Swatches_DB::get_attribute_id_by_taxonomy($taxonomy);
    if (!$attribute_id) return;

    if (EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id) !== 'image') return;

    $image_id = intval($_POST['swatch_image_id']);
    EFA_Swatches_DB::save_swatches_term_meta($term_id, $attribute_id, 'image_id', $image_id);
}, 10, 3);
