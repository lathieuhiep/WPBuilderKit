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

    /**
     * Handle save request
     */
    protected function handle_request(): void
    {
        if (
            empty($_POST['_wpnonce']) ||
            ! wp_verify_nonce($_POST['_wpnonce'], $this->get_nonce_action())
        ) {
            return;
        }

        if (! current_user_can($this->get_capability())) {
            return;
        }

        $enabled = isset($_POST['breadcrumb_enabled']);

        update_option(
            $this->get_option_key(),
            [
                'enabled' => $enabled,
            ]
        );
    }
}