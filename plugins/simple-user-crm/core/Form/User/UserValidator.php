<?php

namespace SimpleUserCRM\Core\Form\User;

use SimpleUserCRM\Core\Database\DBHelper;
use SimpleUserCRM\Core\Database\TableManager;

defined('ABSPATH') || exit;

class UserValidator
{
    /**
     * Validate and sanitize user form data
     */
    public static function validate_user_data(array $input): ?array
    {
        $full_name  = sanitize_text_field($input['full_name'] ?? '');
        $email      = sanitize_email($input['email'] ?? '');
        $raw_phone  = $input['phone'] ?? '';
        $phone      = self::normalize_phone($raw_phone);

        $birth      = $input['birth_date'] ?? '';
        $birth_date = preg_match('/^\d{4}-\d{2}-\d{2}$/', $birth) ? $birth : null;

        // Các trường bắt buộc + kiểm tra trùng
        if (
            empty($full_name) ||
            !is_email($email) ||
            !self::is_valid_vn_phone($phone) ||
            !self::is_unique('email', $email) ||
            !self::is_unique('phone', $phone)
        ) {
            return null;
        }

        return [
            'full_name'   => $full_name,
            'email'       => $email,
            'phone'       => $phone, // đã chuẩn hóa
            'birth_date'  => $birth_date,
            'address'     => isset($input['address']) ? sanitize_text_field($input['address']) : null,
            'referred_by' => isset($input['referred_by']) ? sanitize_text_field($input['referred_by']) : null,
            'note'        => isset($input['note']) ? sanitize_textarea_field($input['note']) : null,
        ];
    }

    /**
     * Chuẩn hóa số điện thoại: chỉ giữ số
     */
    protected static function normalize_phone(string $phone): string
    {
        return preg_replace('/\D+/', '', $phone);
    }

    /**
     * Kiểm tra số điện thoại Việt Nam hợp lệ
     */
    protected static function is_valid_vn_phone(string $phone): bool
    {
        $length = strlen($phone);

        // Di động: 10 số, bắt đầu bằng 03,05,07,08,09
        if ($length === 10 && preg_match('/^0(3|5|7|8|9)[0-9]{8}$/', $phone)) {
            return true;
        }

        // Cố định: 9 số, bắt đầu bằng 02
        if ($length === 9 && preg_match('/^0[2][0-9]{8}$/', $phone)) {
            return true;
        }

        return false;
    }

    /**
     * Kiểm tra xem giá trị đã tồn tại trong bảng người dùng chưa
     */
    protected static function is_unique(string $field, string $value): bool
    {
        $table = TableManager::table_users();
        $row   = DBHelper::get_row($table, [ $field => $value ]);
        return $row === null; // true nếu chưa tồn tại
    }
}