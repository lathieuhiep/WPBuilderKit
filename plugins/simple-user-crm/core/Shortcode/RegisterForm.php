<?php

namespace SimpleUserCRM\Core\Shortcode;

use SimpleUserCRM\constants\FormConstants;
use SimpleUserCRM\Constants\PluginConstants;
use SimpleUserCRM\Core\ShortcodeRegistry;
use SimpleUserCRM\Support\Messages;

class RegisterForm
{
    public static function init(): void
    {
        self::register();
    }

    public static function register(): void
    {
        add_shortcode(ShortcodeRegistry::get_shortcode_tag(ShortcodeRegistry::SHORTCODE_FORM_REGISTER), [self::class, 'render']);
    }

    public static function render(): string
    {
        ob_start();
        ?>
        <div class="su-crm-form su-crm-register-form">
            <?php
            $errors = get_transient(FormConstants::FORM_USER_ERROR_VALIDATE) ?: [];
            $old    = get_transient(FormConstants::FORM_USER_OLD_DATA) ?: [];

            delete_transient(FormConstants::FORM_USER_ERROR_VALIDATE);
            delete_transient(FormConstants::FORM_USER_OLD_DATA);

            $status = get_transient(FormConstants::FORM_USER_REGISTER_STATUS);
            delete_transient(FormConstants::FORM_USER_REGISTER_STATUS);

            if ( $status ):
            ?>
                <div class="su-crm-alert su-crm-alert-<?php echo esc_attr( $status ); ?>">
                    <?php echo esc_html( Messages::get_msg_form_status($status) ); ?>
                </div>
            <?php endif; ?>

            <form id="su-crm-register-form" method="post">
                <div class="su-form-group">
                    <label for="su_crm_full_name">
                        <span><?php esc_html_e('Họ tên', PluginConstants::TEXT_DOMAIN); ?></span>
                        <span class="required">*</span>
                    </label>

                    <input type="text" id="su_crm_full_name" name="su_crm[full_name]" value="<?php echo esc_attr($old['full_name'] ?? ''); ?>" required>

                    <?php if (!empty($errors['full_name'])): ?>
                        <p class="text-error"><?php echo esc_html($errors['full_name']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="su-form-group">
                    <label for="su_crm_email">
                        <?php esc_html_e('Email', PluginConstants::TEXT_DOMAIN); ?>
                        <span class="required">*</span>
                    </label>

                    <input type="email" id="su_crm_email" name="su_crm[email]" value="<?php echo esc_attr($old['email'] ?? ''); ?>" required>

                    <?php if (!empty($errors['email'])): ?>
                        <p class="text-error"><?php echo esc_html($errors['email']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="su-form-group">
                    <label for="su_crm_phone">
                        <?php esc_html_e('Số điện thoại', PluginConstants::TEXT_DOMAIN); ?>
                        <span class="required">*</span>
                    </label>

                    <input type="tel" id="su_crm_phone" name="su_crm[phone]" value="<?php echo esc_attr($old['phone'] ?? ''); ?>" required>

                    <?php if (!empty($errors['phone'])): ?>
                        <p class="text-error"><?php echo esc_html($errors['phone']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="su-form-group">
                    <label for="su_crm_birth_date">
                        <?php esc_html_e('Ngày sinh', PluginConstants::TEXT_DOMAIN); ?>
                    </label>

                    <input type="date" id="su_crm_birth_date" name="su_crm[birth_date]" value="<?php echo esc_attr($old['birth_date'] ?? ''); ?>">

                    <?php if (!empty($errors['birth_date'])): ?>
                        <p class="text-error"><?php echo esc_html($errors['birth_date']); ?></p>
                    <?php endif; ?>
                </div>

                <div class="su-form-group">
                    <label for="su_crm_address">
                        <?php esc_html_e('Địa chỉ', PluginConstants::TEXT_DOMAIN); ?>
                    </label>

                    <input type="text" id="su_crm_address" name="su_crm[address]" value="<?php echo esc_attr($old['address'] ?? ''); ?>">
                </div>

                <div class="su-form-group">
                    <label for="su_crm_referred_by">
                        <?php esc_html_e('Mã giới thiệu (nếu có)', PluginConstants::TEXT_DOMAIN); ?>
                    </label>

                    <input type="text" id="su_crm_referred_by" name="su_crm[referred_by]" value="<?php echo esc_attr($old['referred_by'] ?? ''); ?>">
                </div>

                <div class="su-form-group">
                    <label for="su_crm_note">
                        <?php esc_html_e('Ghi chú thêm', PluginConstants::TEXT_DOMAIN); ?>
                    </label>

                    <textarea id="su_crm_note" name="su_crm[note]" rows="4"><?php echo esc_html($old['note'] ?? ''); ?></textarea>
                </div>

                <div class="su-form-group su-none">
                    <input type="text" id="su_crm_user_bio_fake" name="su_crm[user_bio_fake]" autocomplete="off" aria-label="">
                </div>

                <input type="hidden" name="su_crm[ts]" value="<?php echo time(); ?>">

                <div class="su-form-group">
                    <?php wp_nonce_field(FormConstants::FORM_USER_CREATE_ACTION, FormConstants::FORM_USER_CREATE_NONCE); ?>
                    <button type="submit" name="su_crm_register_form_submit" value="1">
                        <?php esc_html_e('Đăng ký', PluginConstants::TEXT_DOMAIN); ?>
                    </button>
                </div>
            </form>
        </div>
    <?php
        return ob_get_clean();
    }
}