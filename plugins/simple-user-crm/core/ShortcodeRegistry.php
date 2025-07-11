<?php
namespace SimpleUserCRM\Core;

use SimpleUserCRM\Core\Shortcode\RegisterForm;

defined('ABSPATH') || exit;

class ShortcodeRegistry
{
    // Define key shortcodes
    public const SHORTCODE_FORM_REGISTER = 'crm-form-register';

    // Register all shortcodes
    public static function init(): void
    {
        RegisterForm::init();
    }

    public static function get_shortcodes(): array
    {
        return [
            self::SHORTCODE_FORM_REGISTER => 'su_crm_form_register',
        ];
    }

    public static function get_shortcode_tag(string $key): ?string
    {
        $shortcodes = self::get_shortcodes();
        return $shortcodes[$key] ?? null;
    }
}