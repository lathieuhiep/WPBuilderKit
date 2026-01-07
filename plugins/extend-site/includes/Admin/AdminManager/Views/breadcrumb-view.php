<?php
defined('ABSPATH') || exit;
/**
 * @var bool $enabled   (Giá trị hiện tại của option 'enabled')
 * @var array $fields   (Danh sách tên field: ['enabled' => 'breadcrumb_enabled'])
 */
?>

<div class="wrap">
    <h1><?php echo esc_html($this->get_title()); ?></h1>

    <form method="post">
        <?php wp_nonce_field($this->get_nonce_action()); ?>

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
        </table>

        <?php submit_button(); ?>
    </form>
</div>