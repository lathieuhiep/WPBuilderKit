<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

use EFA_Product_UX\Swatches\EFA_Swatches_DB;

function efa_render_swatch_type_select($selected = ''): void
{
?>
    <select name="efa_swatch_type" id="efa_swatch_type">
        <?php foreach (efa_product_ux_swatches() as $key => $text): ?>
            <option value="<?php echo esc_attr( $key ); ?>" <?php selected($selected, $key); ?>>
                <?php echo esc_html( $text ); ?>
            </option>
        <?php endforeach; ?>
    </select>
<?php
}

/**
 * Thêm dropdown swatch type khi tạo mới thuộc tính (Trang: Sản phẩm → Thuộc tính)
 */
add_action('woocommerce_after_add_attribute_fields', 'efa_add_swatch_type_create_field');
function efa_add_swatch_type_create_field(): void
{
?>
    <tr class="form-field">
        <th scope="row">
            <label for="efa_swatch_type">
                <?php esc_html_e('Kiểu hiển thị', EFA_PRODUCT_TEXT_DOMAIN); ?>
            </label>
        </th>

        <td>
            <?php efa_render_swatch_type_select(); ?>

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

    $current_type = EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id);
?>
    <tr class="form-field">
        <th scope="row">
            <label for="efa_swatch_type">
                <?php esc_html_e('Kiểu hiển thị', EFA_PRODUCT_TEXT_DOMAIN); ?>
            </label>
        </th>

        <td>
            <?php efa_render_swatch_type_select($current_type); ?>

            <p class="description">
                <?php esc_html_e('Chọn cách hiển thị của thuộc tính ở giao diện người dùng.', EFA_PRODUCT_TEXT_DOMAIN); ?>
            </p>
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
        EFA_Swatches_DB::save_swatches_attributes((int)$attribute_id, $type);
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
        EFA_Swatches_DB::save_swatches_attributes((int)$attribute_id, $type);
    }
}