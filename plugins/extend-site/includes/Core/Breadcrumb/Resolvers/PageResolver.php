<?php

namespace ExtendSite\Core\Breadcrumb\Resolvers;

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;
use ExtendSite\Core\Breadcrumb\Contracts\BreadcrumbResolverIF;

defined('ABSPATH') || exit;

final class PageResolver implements BreadcrumbResolverIF
{
    /**
     * @return BreadcrumbItem[]
     */
    public function resolve(): array
    {
        $items = [];
        $post = get_post();

        if (!$post || !is_page()) {
            return $items;
        }

        // 1. Lấy danh sách các trang cha (Ancestors)
        // get_ancestors trả về mảng ID từ gần nhất đến xa nhất (con -> cha -> ông)
        $ancestors = get_ancestors($post->ID, 'page');

        if (!empty($ancestors)) {
            // Đảo ngược để có thứ tự: Ông -> Cha -> Con
            $ancestors = array_reverse($ancestors);

            foreach ($ancestors as $ancestor_id) {
                $items[] = new BreadcrumbItem(
                    get_the_title($ancestor_id),
                    get_permalink($ancestor_id),
                    (int) $ancestor_id,
                    'page'
                );
            }
        }

        // 2. Thêm trang hiện tại vào cuối
        $items[] = new BreadcrumbItem(
            get_the_title($post),
            null, // Trang hiện tại không để link
            (int) $post->ID,
            'page'
        );

        return $items;
    }
}