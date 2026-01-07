<?php
defined('ABSPATH') || exit;

/**
 * @var array $options
 */
?>

<div class="wrap">
    <h1><?php esc_html_e('Breadcrumb Settings', 'extend-site'); ?></h1>

    <form method="post">
        <?php wp_nonce_field($this->get_nonce_action()); ?>

        <table class="form-table" role="presentation">
            <tr>
                <th scope="row">
                    <?php esc_html_e('Enable Breadcrumb', 'extend-site'); ?>
                </th>
                <td>
                    <label>
                        <input type="checkbox"
                               name="breadcrumb_enabled"
                               value="1"
                            <?php checked(!empty($options['enabled'])); ?>
                        />
                        <?php esc_html_e('Display breadcrumb on frontend', 'extend-site'); ?>
                    </label>
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
</div>