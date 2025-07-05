<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Thêm dropdown swatch type khi tạo mới thuộc tính (Trang: Sản phẩm → Thuộc tính)
 */
add_action('woocommerce_after_add_attribute_fields', 'efa_add_swatch_type_create_field');
function efa_add_swatch_type_create_field(): void
{
    ?>
    <tr class="form-field">
        <th scope="row"><label for="efa_swatch_type">Kiểu hiển thị</label></th>
        <td>
            <select name="efa_swatch_type" id="efa_swatch_type">
                <option value="button"><?php esc_html_e('Button', EFA_PRODUCT_TEXT_DOMAIN); ?></option>
                <option value="color"><?php esc_html_e('Màu', EFA_PRODUCT_TEXT_DOMAIN); ?></option>
                <option value="image"><?php esc_html_e('Ảnh', EFA_PRODUCT_TEXT_DOMAIN); ?></option>
            </select>

            <p class="description">
                <?php esc_html_e('Chọn cách hiển thị của thuộc tính ở giao diện người dùng.', EFA_PRODUCT_TEXT_DOMAIN); ?>
            </p>
        </td>
    </tr>
    <?php
}

/**
 * Thêm dropdown khi chỉnh sửa thuộc tính (Trang: Sản phẩm → Thuộc tính → Sửa)
 */
add_action('woocommerce_after_edit_attribute_fields', 'efa_add_swatch_type_edit_field');
function efa_add_swatch_type_edit_field(): void
{
    $attribute_id = isset($_GET['edit']) ? absint($_GET['edit']) : 0;
    if (!$attribute_id) return;

    $current_type = get_option('efa_attr_type_' . $attribute_id, 'button');
    ?>
    <tr class="form-field">
        <th scope="row"><label for="efa_swatch_type">Kiểu hiển thị</label></th>
        <td>
            <select name="efa_swatch_type" id="efa_swatch_type">
                <option value="button" <?php selected($current_type, 'button'); ?>>Nút chữ (button)</option>
                <option value="color" <?php selected($current_type, 'color'); ?>>Màu sắc</option>
                <option value="image" <?php selected($current_type, 'image'); ?>>Hình ảnh</option>
            </select>
            <p class="description">Chọn cách hiển thị của thuộc tính ở giao diện người dùng.</p>
        </td>
    </tr>
    <?php
}

/**
 * Lưu swatch_type khi tạo thuộc tính mới
 */
add_action('woocommerce_attribute_added', 'efa_save_swatch_type_on_create', 10, 2);
function efa_save_swatch_type_on_create($attribute_id, $attribute_data): void
{
    if (isset($_POST['efa_swatch_type'])) {
        $type = sanitize_text_field($_POST['efa_swatch_type']);
        update_option('efa_attr_type_' . $attribute_id, $type);
    }
}

/**
 * Lưu swatch_type khi cập nhật thuộc tính
 */
add_action('woocommerce_attribute_updated', 'efa_save_swatch_type_on_update', 10, 2);
function efa_save_swatch_type_on_update($attribute_id, $attribute_data): void
{
    if (isset($_POST['efa_swatch_type'])) {
        $type = sanitize_text_field($_POST['efa_swatch_type']);
        update_option('efa_attr_type_' . $attribute_id, $type);
    }
}
