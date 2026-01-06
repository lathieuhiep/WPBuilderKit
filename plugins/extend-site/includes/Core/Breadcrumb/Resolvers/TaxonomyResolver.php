<?php

namespace ExtendSite\Core\Breadcrumb\Resolvers;

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;
use ExtendSite\Core\Breadcrumb\Contracts\BreadcrumbResolverIF;

defined('ABSPATH') || exit;

final class TaxonomyResolver implements BreadcrumbResolverIF
{
    /**
     * @return BreadcrumbItem[]
     */
    public function resolve(): array
    {
        $items = [];
        $term  = get_queried_object();

        if ( ! $term || is_wp_error( $term ) || empty( $term->term_id ) ) {
            return $items;
        }

        // 1. Lấy tất cả các cấp bậc cha (Ancestors)
        $ancestors = get_ancestors( $term->term_id, $term->taxonomy, 'taxonomy' );
        if ( ! empty( $ancestors ) ) {
            // get_ancestors trả về từ gần nhất đến xa nhất, ta cần đảo ngược lại
            $ancestors = array_reverse( $ancestors );
            foreach ( $ancestors as $ancestor_id ) {
                $ancestor = get_term( $ancestor_id, $term->taxonomy );
                if ( $ancestor && ! is_wp_error( $ancestor ) ) {
                    $items[] = new BreadcrumbItem(
                        $ancestor->name,
                        get_term_link( $ancestor ),
                        (int) $ancestor->term_id,
                        'taxonomy'
                    );
                }
            }
        }

        // 2. Thêm Term hiện tại vào cuối (Không để link cho nấc cuối)
        $items[] = new BreadcrumbItem(
            $term->name,
            null,
            (int) $term->term_id,
            'term'
        );

        return $items;
    }
}