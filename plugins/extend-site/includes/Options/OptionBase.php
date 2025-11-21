<?php

namespace ExtendSite\Options;

defined('ABSPATH') || exit;

/**
 * Base class for all option modules
 */
abstract class OptionBase
{
    /**
     * Wrapper get() to retrieve theme option values
     */
    protected function get(string $key, $default = null)
    {
        if (!function_exists('carbon_get_theme_option')) {
            return $default;
        }

        $value = carbon_get_theme_option($key);

        return ($value === null || $value === '') ? $default : $value;
    }
}