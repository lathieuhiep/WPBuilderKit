<?php

namespace ExtendSite\Admin\AdminManager;

use ExtendSite\Constants\Config;

defined('ABSPATH') || exit;

/**
 * Base class for all admin modules of Extend Site plugin
 */
abstract class BaseAdminModule
{
    protected static array $option_keys = [];

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
        return AdminConstants::PAGE_PREFIX . $this->get_key();
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
        return Config::$path . AdminConstants::PATH_VIEWS . $this->get_view_name() . '.php';
    }

    /**
     * Render admin page
     */
    final public function render(): void
    {
        // Lấy dữ liệu giá trị (Values)
        $options = wp_parse_args(
            get_option($this->get_option_key(), []),
            $this->get_default_options()
        );

        // Tạo mảng tên Field (Names) có sẵn tiền tố
        $field_names = [];
        $module_key = $this->get_key();

        foreach (static::$option_keys as $key) {
            $field_names[$key] = $module_key . '_' . $key;
        }

        // Trích xuất dữ liệu để dùng trong View
        // Dùng mảng $options để lấy giá trị: $enabled
        extract($options);

        // Dùng mảng $field_names để lấy tên input: $fields['enabled']
        $fields = $field_names;

        $view = $this->resolve_view_path();
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
        // Kiểm tra bảo mật cơ bản
        if (empty($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], $this->get_nonce_action())) {
            return;
        }

        if (!current_user_can($this->get_capability())) {
            return;
        }

        // Thu thập dữ liệu dựa trên $option_keys đã khai báo ở lớp con
        $settings_to_save = [];
        foreach (static::$option_keys as $key) {
            // Quy ước: name trong HTML sẽ là {module_key}_{option_key}
            $input_name = $this->get_key() . '_' . $key;

            // Xử lý lưu trữ (ví dụ đơn giản cho checkbox/text)
            $settings_to_save[$key] = isset($_POST[$input_name]) ? sanitize_text_field($_POST[$input_name]) : false;
        }

        // Tận dụng get_option_key() để lưu chính xác vào DB
        if (!empty($settings_to_save)) {
            update_option($this->get_option_key(), $settings_to_save);
        }
    }

    /**
     * Build nonce action name for this module
     */
    protected function get_nonce_action(): string
    {
        return AdminConstants::NONCE_PREFIX . $this->get_key();
    }
}