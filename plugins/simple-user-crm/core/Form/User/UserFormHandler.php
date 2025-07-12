<?php

namespace SimpleUserCRM\Core\Form\User;

use SimpleUserCRM\Core\Database\DBHelper;
use SimpleUserCRM\core\Database\TableManager;
use SimpleUserCRM\Core\Form\BaseValidator;

class UserFormHandler
{
    public const FORM_CREATE_ACTION = 'su_crm_register_form_action';
    public const FORM_CREATE_NONCE = 'su_crm_register_form_nonce';

    public const FORM_UPDATE_ACTION = 'su_crm_update_user_form_action';
    public const FORM_UPDATE_NONCE = 'su_crm_update_user_form_nonce';

    public function init(): void
    {
        add_action('init', [$this, 'handle_create']);
        add_action('init', [$this, 'handle_update']);
        add_action('init', [$this, 'handle_delete']);
    }

    // create user form handler
    public function handle_create(): void
    {
        if (!isset($_POST['su_crm_register_form_submit'], $_POST['su_crm'])) {
            return;
        }

        if (!BaseValidator::verify_nonce($_POST, self::FORM_CREATE_NONCE, self::FORM_CREATE_ACTION)) {
            return;
        }

        $data = UserValidator::validate_user_data($_POST['su_crm']);

        if (!is_array($data)) {
            // Invalid data, redirect with error
            wp_safe_redirect(add_query_arg('su-crm-register-use', 'invalid', wp_get_referer()));
            exit;
        }

        $success = DBHelper::insert(TableManager::table_users(), $data);

        if ($success) {
            wp_safe_redirect(add_query_arg('su-crm-register-use', 'success', wp_get_referer()));
        } else {
            wp_safe_redirect(add_query_arg('su-crm-register-use', 'error', wp_get_referer()));
        }

        exit;
    }

    // update user form handler
    public function handle_update()
    {}

    // delete user form handler
    public function handle_delete()
    {}
}