<?php

namespace ExtendSite\Core\Breadcrumb\Resolvers;

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;
use ExtendSite\Core\Breadcrumb\Contracts\BreadcrumbResolverIF;

defined('ABSPATH') || exit;

final class AuthorResolver implements BreadcrumbResolverIF
{
    /**
     * Resolve Author Breadcrumb Items.
     * * @return BreadcrumbItem[]
     */
    public function resolve(): array
    {
        $items = [];
        $author = get_queried_object();

        // Kiểm tra an toàn: Đảm bảo đối tượng truy vấn đúng là WP_User
        if (!$author instanceof \WP_User) {
            return $items;
        }

        /**
         * Nấc trung gian (Tùy chọn): "Tác giả"
         * cấu trúc: Home > Tác giả > Tên tác giả
         */
        $show_label = apply_filters('extend_site_breadcrumb_show_author_root', false);
        if ($show_label) {
            $items[] = new BreadcrumbItem(
                esc_html__('Authors', 'extend-site'),
                null, // Thường không có trang list-author mặc định trong WP
                null,
                'author_root'
            );
        }

        // Tạo nhãn hiển thị cho tác giả
        $label = sprintf(
            esc_html__('Articles by: %s', 'extend-site'),
            $author->display_name
        );

        // Filter để có thể đổi "Articles by" thành "Tác giả:" hoặc "Writer:"
        $label = apply_filters('extend_site_breadcrumb_author_label', $label, $author);

        $items[] = new BreadcrumbItem(
            $label,
            null, // Nấc cuối không để link
            (int) $author->ID,
            'author'
        );

        return $items;
    }
}