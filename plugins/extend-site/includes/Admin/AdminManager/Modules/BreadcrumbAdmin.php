<?php

namespace ExtendSite\Admin\AdminManager\Modules;

use ExtendSite\Admin\AdminManager\BaseAdminModule;

defined('ABSPATH') || exit;

/**
 * Admin module: Breadcrumb
 */
final class BreadcrumbAdmin extends BaseAdminModule
{

    // -------- Setting --------

    /**
     * Option keys managed by this module
     */
    public const OPTION_ENABLED = 'enabled';
    public const OPTION_SEPARATOR = 'separator';

    protected static array $option_keys = [
        self::OPTION_ENABLED,
        self::OPTION_SEPARATOR,
    ];

    /**
     * Unique module key
     */
    public function get_key(): string
    {
        return 'breadcrumb';
    }

    /**
     * Module title in admin menu
     */
    public function get_title(): string
    {
        return esc_html__('Breadcrumb', 'extend-site');
    }

    // -------- Get options --------

    /**
     * Default options
     */
    public function get_default_options(): array
    {
        return [
            self::OPTION_ENABLED => true,
            self::OPTION_SEPARATOR => '>',
        ];
    }

    // get option enabled
    public function is_enabled(): bool
    {
        return (bool)$this->get_option(self::OPTION_ENABLED, false);
    }

    // get option separator
    public function get_separator(): string
    {
        return (string)$this->get_option(self::OPTION_SEPARATOR, '>');
    }

    // -------- View --------

    /**
     * View file path
     */
    protected function get_view_name(): string
    {
        return 'breadcrumb-view';
    }
}