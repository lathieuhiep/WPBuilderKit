<?php

namespace ExtendSite\Core\Breadcrumb\Resolvers;

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;
use ExtendSite\Core\Breadcrumb\Contracts\BreadcrumbResolverIF;

defined('ABSPATH') || exit;

final class NotFoundResolver implements BreadcrumbResolverIF
{
    public function resolve(): array
    {
        $items = [];

        $items[] = new BreadcrumbItem(
            apply_filters('extend_site_breadcrumb_404_label', esc_html__('Error 404: Page Not Found', 'extend-site')),
            null,
            null,
            '404'
        );

        return $items;
    }
}