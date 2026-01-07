<?php

namespace ExtendSite\Admin\AdminManager;

use ExtendSite\Constants\Config;

defined('ABSPATH') || exit;

/**
 * Base class for all admin modules of Extend Site plugin
 */
abstract class BaseAdminModule
{
    /**
     * Unique module key
     */
    abstract public function get_key(): string;

    /**
     * Title shown in admin menu
     */
    abstract public function get_title(): string;

    /**
     * Capability required to access this module
     */
    public function get_capability(): string
    {
        return AdminConstants::CAPABILITY_MANAGE;
    }

    /**
     * Admin page slug (used in URL)
     * Example: extend-site-admin-breadcrumb
     */
    public function get_page_slug(): string
    {
        return AdminConstants::PAGE_PREFIX . '_' . $this->get_key();
    }

    /**
     * Option key used to store settings
     * Example: extend_site_admin_breadcrumb
     */
    public function get_option_key(): string
    {
        return AdminConstants::OPTION_PREFIX . $this->get_key();
    }

    /**
     * Default option values
     */
    public function get_default_options(): array
    {
        return [];
    }

    /**
     * Entry point for admin module lifecycle
     */
    final public function boot(): void
    {
        $this->register_menu();
        $this->handle_request();
    }

    /**
     * Register submenu page under Extend Site menu
     */
    protected function register_menu(): void
    {
        add_submenu_page(
            AdminConstants::MENU_PARENT,
            $this->get_title(),
            $this->get_title(),
            $this->get_capability(),
            $this->get_page_slug(),
            [$this, 'render']
        );
    }

    /**
     * View name without extension
     * Example: breadcrumb-view
     */
    abstract protected function get_view_name(): string;

    /**
     * Resolve absolute view path
     */
    final protected function resolve_view_path(): string
    {
        return Config::$path . 'includes/Admin/AdminManager/Views/' . $this->get_view_name() . '.php';
    }

    /**
     * Render admin page
     */
    final public function render(): void
    {
        $options = wp_parse_args(
            get_option($this->get_option_key(), []),
            $this->get_default_options()
        );

        $view = $this->resolve_view_path();

        error_log('Parent slug: ' . $view);


        if (is_readable($view)) {
            require $view;
        }
    }

    /**
     * Handle POST / save logic
     * Override in child module if needed
     */
    protected function handle_request(): void
    {
        // intentionally left blank
    }

    /**
     * Build nonce action name for this module
     */
    protected function get_nonce_action(): string
    {
        return AdminConstants::NONCE_PREFIX . $this->get_key();
    }
}