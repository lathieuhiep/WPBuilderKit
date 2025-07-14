<?php

namespace SimpleUserCRM\Constants;

class FormConstants
{
    // Form action and nonce constants for user registration and update forms
    public const FORM_USER_CREATE_ACTION = 'su_crm_register_form_action';
    public const FORM_USER_CREATE_NONCE = 'su_crm_register_form_nonce';

    // Form action and nonce constants for user update forms
    public const FORM_UPDATE_ACTION = 'su_crm_update_user_form_action';
    public const FORM_UPDATE_NONCE = 'su_crm_update_user_form_nonce';

    // key for transient storage of form data
    public const FORM_USER_ERROR_VALIDATE = 'su_crm_user_form_errors';
    public const FORM_USER_OLD_DATA = 'su_crm_user_form_old';
    public const FORM_USER_REGISTER_STATUS = 'su_crm_register_status';
}