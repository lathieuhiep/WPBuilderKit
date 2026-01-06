<?php

namespace ExtendSite\Core\Breadcrumb\Resolvers;

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;
use ExtendSite\Core\Breadcrumb\Contracts\BreadcrumbResolverIF;

defined('ABSPATH') || exit;

final class SearchResolver implements BreadcrumbResolverIF
{
    /**
     * Resolve Search Breadcrumb Items.
     * * @return BreadcrumbItem[]
     */
    public function resolve(): array
    {
        $items = [];
        $query = get_search_query();

        // Kiểm tra xem có kết quả tìm kiếm nào không
        global $wp_query;
        $found = $wp_query->found_posts;

        if ($found > 0) {
            $label = sprintf(
                esc_html__('Search results for "%s"', 'extend-site'),
                $query
            );
        } else {
            // Nhãn khi không tìm thấy kết quả
            $label = sprintf(
                esc_html__('No results found for "%s"', 'extend-site'),
                $query
            );
        }

        // Cho phép can thiệp vào nhãn tìm kiếm qua filter
        $label = apply_filters('extend_site_breadcrumb_search_label', $label, $query, $found);

        $items[] = new BreadcrumbItem(
            $label,
            null, // Nấc cuối cùng không có link
            null,
            'search'
        );

        return $items;
    }
}