<?php
use ExtendSite\Core\Breadcrumb\BreadcrumbService;

defined('ABSPATH') || exit;

/**
 * Render breadcrumb (for theme).
 */
function extend_site_breadcrumb(): void
{
    BreadcrumbService::instance()->render();
}

/**
 * Get breadcrumb items (for custom rendering).
 */
function extend_site_get_breadcrumb_items(): array
{
    return BreadcrumbService::instance()->get_items();
}