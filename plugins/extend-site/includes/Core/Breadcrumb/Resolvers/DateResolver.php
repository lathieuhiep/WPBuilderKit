<?php

namespace ExtendSite\Core\Breadcrumb\Resolvers;

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;
use ExtendSite\Core\Breadcrumb\Contracts\BreadcrumbResolverIF;

defined('ABSPATH') || exit;

final class DateResolver implements BreadcrumbResolverIF
{
    /**
     * Resolve Date Breadcrumb Items.
     * * @return BreadcrumbItem[]
     */
    public function resolve(): array
    {
        $items = [];

        $year  = get_query_var('year');
        $month = get_query_var('monthnum');
        $day   = get_query_var('day');

        // 1. Năm (Year)
        if ($year) {
            $items[] = new BreadcrumbItem(
                (string) $year,
                get_year_link($year),
                null,
                'date_year'
            );
        }

        // 2. Tháng (Month)
        if ($month) {
            // Sử dụng WP_Locale để lấy tên tháng chuẩn theo ngôn ngữ website
            global $wp_locale;
            $month_name = $wp_locale->get_month($month);

            $items[] = new BreadcrumbItem(
                $month_name,
                get_month_link($year, $month),
                null,
                'date_month'
            );
        }

        // 3. Ngày (Day)
        if ($day) {
            $items[] = new BreadcrumbItem(
                sprintf(esc_html__('Day %s', 'extend-site'), $day),
                null, // Nấc cuối không link
                null,
                'date_day'
            );
        }

        // Xóa link của nấc cuối cùng (đảm bảo SEO: tránh self-link)
        if (!empty($items)) {
            $last_key = array_key_last($items);
            $items[$last_key]->url = null;
        }

        return apply_filters('extend_site_breadcrumb_date_items', $items, $year, $month, $day);
    }
}