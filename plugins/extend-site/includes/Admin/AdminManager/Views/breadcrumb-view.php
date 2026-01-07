<?php
defined('ABSPATH') || exit;
/**
 * @var string $title (Tiêu đề trang admin)
 * @var string $nonce_field (Trường nonce để bảo vệ form)
 * @var bool $enabled (Giá trị hiện tại của option 'enabled')
 * @var string $separator (Giá trị hiện tại của option 'separator')
 * @var array $fields (Danh sách tên field: ['enabled' => 'breadcrumb_enabled'])
 */
?>

<div class="wrap">
    <h1><?php echo esc_html($title); ?></h1>

    <form method="post">
        <?php echo $nonce_field; ?>

        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Enable Breadcrumb', 'extend-site'); ?></th>
                <td>
                    <label>
                        <input type="checkbox"
                               name="<?php echo esc_attr($fields['enabled']); ?>"
                               value="1"
                            <?php checked(!empty($enabled)); ?>
                        />
                        <?php esc_html_e('Display breadcrumb on frontend', 'extend-site'); ?>
                    </label>
                </td>
            </tr>

            <tr>
                <th><?php _e('Separator', 'extend-site'); ?></th>
                <td>
                    <input type="text"
                           name="<?php echo $fields['separator']; ?>"
                           value="<?php echo esc_attr($separator); ?>">
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>