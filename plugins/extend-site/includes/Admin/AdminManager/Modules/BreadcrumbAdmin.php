<?php

namespace ExtendSite\Admin\AdminManager\Modules;

use ExtendSite\Admin\AdminManager\BaseAdminModule;

defined('ABSPATH') || exit;

/**
 * Admin module: Breadcrumb
 */
final class BreadcrumbAdmin extends BaseAdminModule
{
    /**
     * Option keys managed by this module
     */
    protected static array $option_keys = ['enabled'];

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

    /**
     * Default options
     */
    public function get_default_options(): array
    {
        return [
            'enabled' => true,
        ];
    }

    /**
     * View file path
     */
    protected function get_view_name(): string
    {
        return 'breadcrumb-view';
    }
}