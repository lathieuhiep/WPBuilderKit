<?php

namespace SimpleUserCRM\Support;

use SimpleUserCRM\Constants\PluginConstants;

class Messages
{
    // Define messages for various operations
    public static function msg_form_status(): array
    {
        return [
            'success' => esc_html__('Đăng ký thành công!', PluginConstants::TEXT_DOMAIN),
            'error' => esc_html__('Có lỗi xảy ra. Vui lòng thử lại sau.', PluginConstants::TEXT_DOMAIN),
            'rate_limited' => esc_html__('Bạn đang thao tác quá nhanh, vui lòng thử lại sau.', PluginConstants::TEXT_DOMAIN),
        ];
    }

    // get a specific message by key
    public static function get_msg_form_status(string $key): string
    {
        $messages = self::msg_form_status();
        return $messages[$key] ?? '';
    }

    // Define validation messages for form fields
    public static function msg_form_validate(): array
    {
        return [
            'required' => esc_html__('Trường này là bắt buộc.', PluginConstants::TEXT_DOMAIN),
            'full_name' => esc_html__('Vui lòng nhập họ tên.', PluginConstants::TEXT_DOMAIN),

            'email' => esc_html__('Email không hợp lệ.', PluginConstants::TEXT_DOMAIN),
            'email_exists' => esc_html__('Email đã được sử dụng.', PluginConstants::TEXT_DOMAIN),

            'phone' => esc_html__('Số điện thoại không hợp lệ.', PluginConstants::TEXT_DOMAIN),
            'phone_exists' => esc_html__('Số điện thoại đã được sử dụng.', PluginConstants::TEXT_DOMAIN),

            'date_format' => esc_html__('Định dạng không hợp lệ.', PluginConstants::TEXT_DOMAIN),
        ];
    }

    // get a specific message by key
    public static function get_msg_validate(string $key): string
    {
        $messages = self::msg_form_validate();
        return $messages[$key] ?? '';
    }
}