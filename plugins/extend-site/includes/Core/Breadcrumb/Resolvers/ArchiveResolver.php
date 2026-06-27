<?php

namespace ExtendSite\Core\Breadcrumb\Resolvers;

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;
use ExtendSite\Core\Breadcrumb\Contracts\BreadcrumbResolverIF;

defined('ABSPATH') || exit;

final class ArchiveResolver implements BreadcrumbResolverIF
{
    /**
     * Resolve Post Type Archive Breadcrumb Items.
     * * @return BreadcrumbItem[]
     */
    public function resolve(): array
    {
        $items = [];

        if (!is_post_type_archive()) {
            return $items;
        }

        $post_type_obj = get_queried_object();

        if (!$post_type_obj instanceof \WP_Post_Type) {
            return $items;
        }

        // Lấy tên hiển thị mặc định
        $label = $post_type_obj->labels->name;

        /**
         * Trường hợp đặc biệt: WooCommerce hoặc CPT có chỉ định một trang làm Archive.
         * Chúng ta ưu tiên lấy tiêu đề của trang đó nếu nó tồn tại.
         */
        $label = apply_filters('extend_site_breadcrumb_archive_label', $label, $post_type_obj->name);

        $items[] = new BreadcrumbItem(
            $label,
            null, // Nấc cuối cùng trên trang archive không cần link
            null,
            'archive'
        );

        return $items;
    }
}