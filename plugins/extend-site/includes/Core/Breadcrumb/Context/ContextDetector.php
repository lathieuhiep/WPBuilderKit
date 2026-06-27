<?php

namespace ExtendSite\Core\Breadcrumb\Context;

defined('ABSPATH') || exit;

final class ContextDetector
{
    /**
     * Detect current WordPress context.
     *
     * @return string
     */
    public function detect(): string
    {
        return match (true) {
            // Trang chủ
            is_front_page() || is_home() => 'home',

            // Trang tĩnh & Bài viết đơn lẻ
            is_page() => 'page',
            is_singular() => 'single', // Bao gồm cả Post và CPT (Sản phẩm, dự án...)

            // Taxonomy (Danh mục, Thẻ)
            is_category() || is_tag() || is_tax() => 'taxonomy',

            // Các loại Archives (Quan trọng cho CPT và Date)
            is_post_type_archive() => 'archive', // Trang chủ của CPT (ví dụ: /san-pham/)
            is_date() => 'date',    // Lưu trữ thời gian (2018/11/...)
            is_author() => 'author',  // Lưu trữ tác giả

            // Các trang hệ thống
            is_search() => 'search',
            is_404() => '404',
            is_privacy_policy() => 'page',

            // Trường hợp dự phòng (Fallback)
            is_archive() => 'archive',
            default => 'default',
        };
    }
}
