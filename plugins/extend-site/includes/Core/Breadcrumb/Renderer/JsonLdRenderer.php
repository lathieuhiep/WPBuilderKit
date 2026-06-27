<?php

namespace ExtendSite\Core\Breadcrumb\Renderer;

use ExtendSite\Core\Breadcrumb\BreadcrumbItem;

defined('ABSPATH') || exit;

final class JsonLdRenderer
{
    /**
     * Render BreadcrumbList JSON-LD.
     *
     * @param BreadcrumbItem[] $items
     */
    public function render(array $items): void
    {
        if (empty($items)) {
            return;
        }

        $list_items = [];
        foreach ($items as $index => $item) {
            $data = [
                '@type'    => 'ListItem',
                'position' => $index + 1,
                'name'     => $item->label,
            ];

            // Thêm URL nếu có, trừ nấc cuối cùng (tùy chọn theo khuyến nghị của Google)
            if ($item->url) {
                $data['item'] = esc_url($item->url);
            }

            $list_items[] = $data;
        }

        $schema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $list_items,
        ];

        echo "\n" . '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}