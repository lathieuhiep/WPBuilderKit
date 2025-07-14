<?php

namespace SimpleUserCRM\Core\Form\User;

use SimpleUserCRM\Core\Database\TableManager;
use SimpleUserCRM\Support\Helpers;
use SimpleUserCRM\Support\Messages;

defined('ABSPATH') || exit;

class UserValidator
{
    /**
     * Validate and sanitize user form data
     */
    public static function validate_user_data(array $input): array
    {
        $table_users = TableManager::table_users();
        $errors = [];
        $data = [];

        // validate full_name
        $data['full_name'] = sanitize_text_field($input['full_name'] ?? '');
        if (empty($data['full_name'])) {
            $errors['full_name'] = Messages::get_msg_validate('full_name');
        }

        // validate email
        $raw_email = $input['email'] ?? '';
        $email = sanitize_email($raw_email);

        if (empty($raw_email)) {
            $errors['email'] = Messages::get_msg_validate('required');
            $data['email'] = '';
        } elseif (empty($email) || !is_email($email)) {
            $errors['email'] = Messages::get_msg_validate('email');
            $data['email'] = $raw_email;
        } elseif (!Helpers::is_unique('email', $email, $table_users)) {
            $errors['email'] = Messages::get_msg_validate('email_exists');
            $data['email'] = $raw_email;
        } else {
            $data['email'] = $email;
        }

        // validate phone
        $raw_phone = $input['phone'] ?? '';
        $data['phone'] = Helpers::normalize_phone($raw_phone);
        if (empty($data['phone'])) {
            $errors['phone'] = Messages::get_msg_validate('required');
        } elseif (!Helpers::is_valid_vn_phone($data['phone'])) {
            $errors['phone'] = Messages::get_msg_validate('phone');
        } elseif (!Helpers::is_unique('phone', $data['phone'], $table_users)) {
            $errors['phone'] = Messages::get_msg_validate('phone_exists');
        }

        // validate birth_date
        $birth = $input['birth_date'] ?? '';
        if (!empty($birth) && !Helpers::is_check_date_format($birth)) {
            $errors['birth_date'] = Messages::get_msg_validate('date_format');
        }
        $data['birth_date'] = $birth;

        // validate other fields
        $data['address'] = sanitize_text_field($input['address'] ?? '');
        $data['referred_by'] = sanitize_text_field($input['referred_by'] ?? '');
        $data['note'] = sanitize_textarea_field($input['note'] ?? '');

        return ['errors' => $errors, 'data' => $data];
    }
}