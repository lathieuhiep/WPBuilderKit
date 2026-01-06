<?php

namespace ExtendSite\Core\Breadcrumb\Resolvers;

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;
use ExtendSite\Core\Breadcrumb\Contracts\BreadcrumbResolverIF;

defined('ABSPATH') || exit;

final class HomeResolver implements BreadcrumbResolverIF
{
    /**
     * @return BreadcrumbItem[]
     */
    public function resolve(): array
    {
        // Trang chủ không cần breadcrumb
        return [];
    }
}