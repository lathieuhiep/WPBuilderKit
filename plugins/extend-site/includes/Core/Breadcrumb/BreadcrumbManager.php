<?php

namespace ExtendSite\Core\Breadcrumb;

use ExtendSite\Core\Breadcrumb\Context\ContextDetector;
use ExtendSite\Core\Breadcrumb\Contracts\BreadcrumbResolverIF;
use ExtendSite\Core\Breadcrumb\Resolvers\ArchiveResolver;
use ExtendSite\Core\Breadcrumb\Resolvers\AuthorResolver;
use ExtendSite\Core\Breadcrumb\Resolvers\DateResolver;
use ExtendSite\Core\Breadcrumb\Resolvers\HomeResolver;
use ExtendSite\Core\Breadcrumb\Resolvers\NotFoundResolver;
use ExtendSite\Core\Breadcrumb\Resolvers\PageResolver;
use ExtendSite\Core\Breadcrumb\Resolvers\SearchResolver;
use ExtendSite\Core\Breadcrumb\Resolvers\SingleResolver;
use ExtendSite\Core\Breadcrumb\Resolvers\TaxonomyResolver;

defined('ABSPATH') || exit;

final class BreadcrumbManager
{
    /**
     * Get breadcrumb items for current request.
     *
     * @return BreadcrumbItem[]
     */
    public function get_items(): array
    {
        $context = (new ContextDetector())->detect();

        $key = $this->get_cache_key($context);

        $cached = wp_cache_get($key, 'extend-site');
        if (false !== $cached) {
            return $cached;
        }

        $resolver = $this->resolve_resolver($context);
        $items = (array)$resolver?->resolve();

        // --- XỬ LÝ LOGIC CHUNG TẠI ĐÂY ---

        // Nếu không phải trang chủ, luôn thêm "Home" vào đầu
        if ($context !== 'home') {

            $home_items = [];
            $home_items[] = new BreadcrumbItem(
                esc_html__('Home', 'extend-site'),
                home_url('/'),
                null,
                'home'
            );

            // Thêm "Blog Page" nếu đang xem bài viết hoặc archive tin tức
            // Chỉ thêm nếu người dùng thiết lập "Post page" trong Settings > Reading
            $blog_page_id = (int)get_option('page_for_posts');
            if ($blog_page_id && $this->should_show_blog_link($context)) {
                $home_items[] = new BreadcrumbItem(
                    get_the_title($blog_page_id),
                    get_permalink($blog_page_id),
                    $blog_page_id,
                    'page'
                );
            }

            $items = array_merge($home_items, $items);
        } else {
            $items = [
                new BreadcrumbItem(
                    esc_html__('Home', 'extend-site'),
                    home_url('/'),
                    null,
                    'home'
                )
            ];
        }

        // Thêm thông tin phân trang nếu có
        $paged = max(1, get_query_var('paged'), get_query_var('page'));

        if ($paged > 1 && !empty($items)) {
            $last_index = array_key_last($items);

            // Sử dụng filter để người dùng có thể đổi "Trang 2" thành "Page 2" hoặc "P. 2"
            $paged_text = apply_filters(
                'extend_site_breadcrumb_paged_text',
                sprintf(' - ' . esc_html__('Page %d', 'extend-site'), $paged),
                $paged
            );

            $items[$last_index]->label .= $paged_text;
        }

        // Áp dụng filter để tùy chỉnh thêm
        $items = apply_filters('extend_site_breadcrumb_items', $items, $context);

        // Lưu cache trong 15 phút
        wp_cache_set($key, $items, 'extend-site', 15 * MINUTE_IN_SECONDS);

        return $items;
    }

    /**
     * Kiểm tra xem có nên chèn link trang Blog vào giữa không
     */
    private function should_show_blog_link(string $context): bool
    {
        $blog_page_id = (int) get_option('page_for_posts');

        if (!$blog_page_id) {
            return false;
        }

        // Nếu đang ở chính trang Blog thì không cần chèn thêm link tới chính nó
        if (is_home()) {
            return false;
        }

        // Chỉ áp dụng cho single, taxonomy, archive
        if (!in_array($context, ['single', 'taxonomy', 'archive'], true)) {
            return false;
        }

        // Kiểm tra Post Type của đối tượng hiện tại
        $post_type = get_post_type();

        // Nếu là Taxonomy (Category/Tag), kiểm tra xem nó có thuộc về 'post' không
        if (is_category() || is_tag() || is_tax()) {
            $term = get_queried_object();
            if ($term instanceof \WP_Term) {
                $tax_obj = get_taxonomy($term->taxonomy);
                return in_array('post', $tax_obj->object_type, true);
            }
        }

        // Nếu là Single hoặc Archive, chỉ hiện nếu là 'post'
        return ($post_type === 'post');
    }

    /**
     * Pick resolver by context.
     */
    private function resolve_resolver(string $context): ?BreadcrumbResolverIF
    {
        return match ($context) {
            'home' => new HomeResolver(),
            'page' => new PageResolver(),
            'single' => new SingleResolver(),
            'taxonomy' => new TaxonomyResolver(),
            'archive' => new ArchiveResolver(),
            'date' => new DateResolver(),
            'author' => new AuthorResolver(),
            'search' => new SearchResolver(),
            '404' => new NotFoundResolver(),
            default => null,
        };
    }

    /**
     * Generate cache key for breadcrumb items.
     */
    private function get_cache_key(string $context): string
    {
        // Tạo key riêng cho từng post/page
        if (is_singular()) {
            return 'es_bc_' . get_the_ID();
        }

        // Tạo key riêng cho từng term
        if (is_tax() || is_category() || is_tag()) {
            $term = get_queried_object();
            return 'es_bc_term_' . ($term->term_id ?? 0);
        }

        // Thêm cho trang Search
        if (is_search()) {
            return 'es_bc_search_' . md5(get_search_query());
        }

        // Thêm cho trang Date
        if (is_date()) {
            return 'es_bc_date_' . get_the_date('Ymd');
        }

        // Thêm cho trang Author
        if (is_author()) {
            return 'es_bc_auth_' . get_queried_object_id();
        }

        return 'es_bc_ctx_' . $context;
    }
}
