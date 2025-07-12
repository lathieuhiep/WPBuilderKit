<?php

namespace SimpleUserCRM\Core\Form;

defined('ABSPATH') || exit;

class BaseValidator
{
    public static function verify_nonce(array $source, string $field, string $action): bool
    {
        return isset($source[$field]) && wp_verify_nonce($source[$field], $action);
    }
}