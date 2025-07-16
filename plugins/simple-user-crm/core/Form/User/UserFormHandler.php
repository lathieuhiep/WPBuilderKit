<?php

namespace SimpleUserCRM\Core\Form\User;

use SimpleUserCRM\constants\FormConstants;
use SimpleUserCRM\Constants\TableConstants;
use SimpleUserCRM\Core\Database\DBHelper;
use SimpleUserCRM\Core\Form\BaseValidator;

class UserFormHandler
{
    public function init(): void
    {
        add_action('init', [$this, 'handle_create']);
        add_action('init', [$this, 'handle_update']);
        add_action('init', [$this, 'handle_delete']);
    }

    // create user form handler
    public function handle_create(): void
    {
        // check if the form is submitted
        if (empty($_POST['su_crm']) || empty($_POST['su_crm_register_form_submit'])) {
            return;
        }

        if (!BaseValidator::verify_nonce($_POST, FormConstants::FORM_USER_CREATE_NONCE, FormConstants::FORM_USER_CREATE_ACTION)) {
            return;
        }

        if (!empty($_POST['su_crm']['user_bio_fake'])) {
            return;
        }

        $ts = intval($_POST['su_crm']['ts'] ?? 0);
        if ($ts === 0 || (time() - $ts) < 5) {
            return;
        }

        // rate limiting to prevent spam
        $user_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = 'su_crm_rate_limit_' . md5($user_ip);

        if (false !== get_transient($key)) {
            set_transient(FormConstants::FORM_USER_REGISTER_STATUS, 'rate_limited', 30);

            wp_safe_redirect(add_query_arg('', '', wp_get_referer()));
            exit;
        }
        set_transient($key, '1', 30); // 30 seconds rate limit

        // validate and sanitize user data
        $result = UserValidator::validate_user_data($_POST['su_crm']);

        if (!empty($result['errors'])) {
            set_transient(FormConstants::FORM_USER_ERROR_VALIDATE, $result['errors'], 60);
            set_transient(FormConstants::FORM_USER_OLD_DATA, $result['data'], 60);

            wp_safe_redirect(add_query_arg('', '', wp_get_referer()));
            exit;
        }

        // save user data
        $success = DBHelper::insert(TableConstants::table_users(), $result['data']);

        if ($success) {
            set_transient(FormConstants::FORM_USER_REGISTER_STATUS, 'success', 30);
        } else {
            set_transient(FormConstants::FORM_USER_REGISTER_STATUS, 'error', 30);
        }

        wp_safe_redirect(add_query_arg('', '', wp_get_referer()));
        exit;
    }

    // update user form handler
    public function handle_update()
    {}

    // delete user form handler
    public function handle_delete()
    {}
}