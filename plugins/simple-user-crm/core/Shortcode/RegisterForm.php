<?php

namespace SimpleUserCRM\Core\Shortcode;

use SimpleUserCRM\Core\Constants;
use SimpleUserCRM\Core\Form\User\UserFormHandler;
use SimpleUserCRM\Core\ShortcodeRegistry;

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
            if (isset($_GET['su-crm-register-use'])):
                $status = $_GET['su-crm-register-use'];
                $messages = [
                    'success' => ['type' => 'success', 'text' => 'Đăng ký thành công!'],
                    'invalid' => ['type' => 'warning', 'text' => 'Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.'],
                    'error' => ['type' => 'danger', 'text' => 'Có lỗi xảy ra. Vui lòng thử lại sau.'],
                ];
                if (isset($messages[$status])):
                    $msg = $messages[$status];
                    ?>
                    <div class="su-crm-alert alert alert-<?php echo esc_attr($msg['type']); ?>">
                        <?php echo esc_html($msg['text']); ?>
                    </div>
                <?php
                endif;
            endif;
            ?>

            <form id="su-crm-register-form" method="post">
                <div class="su-form-group">
                    <label for="su_crm_full_name">
                        <span><?php esc_html_e('Họ tên', Constants::TEXT_DOMAIN); ?></span>
                        <span class="required">*</span>
                    </label>
                    <input type="text" id="su_crm_full_name" name="su_crm[full_name]" required>
                </div>

                <div class="su-form-group">
                    <label for="su_crm_email">
                        <?php esc_html_e('Email', Constants::TEXT_DOMAIN); ?>
                        <span class="required">*</span>
                    </label>
                    <input type="email" id="su_crm_email" name="su_crm[email]" required>
                </div>

                <div class="su-form-group">
                    <label for="su_crm_phone">
                        <?php esc_html_e('Số điện thoại', Constants::TEXT_DOMAIN); ?>
                        <span class="required">*</span>
                    </label>
                    <input type="text" id="su_crm_phone" name="su_crm[phone]" required>
                </div>

                <div class="su-form-group">
                    <label for="su_crm_birth_date">
                        <?php esc_html_e('Ngày sinh', Constants::TEXT_DOMAIN); ?>
                    </label>
                    <input type="date" id="su_crm_birth_date" name="su_crm[birth_date]">
                </div>

                <div class="su-form-group">
                    <label for="su_crm_address">
                        <?php esc_html_e('Địa chỉ', Constants::TEXT_DOMAIN); ?>
                    </label>
                    <input type="text" id="su_crm_address" name="su_crm[address]">
                </div>

                <div class="su-form-group">
                    <label for="su_crm_referred_by">
                        <?php esc_html_e('Mã giới thiệu (nếu có)', Constants::TEXT_DOMAIN); ?>
                    </label>
                    <input type="text" id="su_crm_referred_by" name="su_crm[referred_by]">
                </div>

                <div class="su-form-group">
                    <label for="su_crm_note">
                        <?php esc_html_e('Ghi chú thêm', Constants::TEXT_DOMAIN); ?>
                    </label>
                    <textarea id="su_crm_note" name="su_crm[note]" rows="4"></textarea>
                </div>

                <div class="su-form-group">
                    <?php wp_nonce_field(UserFormHandler::FORM_CREATE_ACTION, UserFormHandler::FORM_CREATE_NONCE); ?>
                    <button type="submit" name="su_crm_register_form_submit" value="1">
                        <?php esc_html_e('Đăng ký', Constants::TEXT_DOMAIN); ?>
                    </button>
                </div>
            </form>
        </div>
    <?php
        return ob_get_clean();
    }
}