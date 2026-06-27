<?php

namespace ExtendSite\Core\Breadcrumb\Contracts;

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;

defined('ABSPATH') || exit;

interface BreadcrumbResolverIF
{
    /**
     * Build breadcrumb items for current context.
     *
     * @return array<BreadcrumbItem>
     */
    public function resolve(): array;
}