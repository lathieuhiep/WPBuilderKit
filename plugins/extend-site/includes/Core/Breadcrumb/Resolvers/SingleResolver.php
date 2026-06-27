<?php

namespace ExtendSite\Core\Breadcrumb\Resolvers;

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;
use ExtendSite\Core\Breadcrumb\Contracts\BreadcrumbResolverIF;
use WP_Term;

defined('ABSPATH') || exit;

final class SingleResolver implements BreadcrumbResolverIF
{
    /**
     * @return BreadcrumbItem[]
     */
    public function resolve(): array
    {
        $items = [];
        $post = get_post();

        if (!$post) {
            return $items;
        }

        // 1. Post type archive (Nếu có)
        $pt_obj = get_post_type_object($post->post_type);
        if ($pt_obj && !empty($pt_obj->has_archive)) {
            $items[] = new BreadcrumbItem(
                $pt_obj->labels->name,
                get_post_type_archive_link($post->post_type),
                null,
                'archive'
            );
        }

        // 2. Xử lý Taxonomy/Category (Lấy toàn bộ cấp bậc cha)
        $taxonomy = $this->get_primary_taxonomy($post);
        $terms = get_the_terms($post->ID, $taxonomy);

        if (!is_wp_error($terms) && !empty($terms)) {
            // Lấy term đầu tiên (hoặc term được chọn làm primary nếu bạn tích hợp thêm logic filter)
            $term = $this->get_best_term_match($terms, $taxonomy, $post->ID);

            // Tìm tất cả tổ tiên (ancestors) của term này
            $ancestors = get_ancestors($term->term_id, $taxonomy, 'taxonomy');
            if (!empty($ancestors)) {
                $ancestors = array_reverse($ancestors);
                foreach ($ancestors as $ancestor_id) {
                    $ancestor = get_term($ancestor_id, $taxonomy);
                    $items[] = new BreadcrumbItem(
                        $ancestor->name,
                        get_term_link($ancestor),
                        (int)$ancestor->term_id,
                        'term'
                    );
                }
            }

            // Thêm chính cái term đó vào
            $items[] = new BreadcrumbItem(
                $term->name,
                get_term_link($term),
                (int)$term->term_id,
                'term'
            );
        }

        // 3. Cuối cùng là tiêu đề bài viết hiện tại
        $items[] = new BreadcrumbItem(
            get_the_title($post),
            null, // Nấc cuối không để link
            (int)$post->ID,
            'single'
        );

        return $items;
    }

    /**
     * Lấy taxonomy chính để hiển thị trong breadcrumb cho bài viết.
     * Mặc định là 'category', nhưng có thể thay đổi qua filter.
     */
    private function get_primary_taxonomy($post): string
    {
        return apply_filters('extend_site_breadcrumb_primary_taxonomy', 'category', $post);
    }

    /**
     * Lấy term phù hợp nhất dựa trên các tiêu chí:
     * 1. Primary Category từ Yoast SEO hoặc Rank Math
     * 2. Nếu không có, lấy term sâu nhất (deepest child)
     *
     * @param WP_Term[] $terms
     * @param string $taxonomy
     * @param int $post_id
     * @return WP_Term|null
     */
    private function get_best_term_match(array $terms, string $taxonomy, int $post_id): ?WP_Term
    {
        if (empty($terms)) return null;

        // 1. Kiểm tra Primary Category từ Yoast SEO
        $primary_term_id = get_post_meta($post_id, '_yoast_wpseo_primary_' . $taxonomy, true);

        // 2. Nếu không có Yoast, kiểm tra Rank Math
        if (!$primary_term_id) {
            $primary_term_id = get_post_meta($post_id, 'rank_math_primary_' . $taxonomy, true);
        }

        if ($primary_term_id) {
            $primary_term = get_term($primary_term_id, $taxonomy);
            if ($primary_term && !is_wp_error($primary_term)) {
                return $primary_term;
            }
        }

        // 3. Nếu không có Primary, tìm Term sâu nhất (Deepest Child)
        $deepest_term = $terms[0];
        $max_depth = 0;

        foreach ($terms as $term) {
            $ancestors = get_ancestors($term->term_id, $taxonomy);
            $depth = count($ancestors);
            if ($depth > $max_depth) {
                $max_depth = $depth;
                $deepest_term = $term;
            }
        }

        return $deepest_term;
    }
}