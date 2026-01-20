<?php

namespace ExtendSite\Core\Breadcrumb\Renderer;

use ExtendSite\Constants\Config;
use ExtendSite\Core\Breadcrumb\BreadcrumbItem;

defined('ABSPATH') || exit;

final class HtmlRenderer
{
    /**
     * Render breadcrumb using plugin template.
     *
     * @param array $data
     */
    public function render(array $data): void
    {
        $items = $data['items'] ?? [];

        if (empty($items)) {
            return;
        }

        /**
         * Plugin root path
         */
        $template = Config::$path . 'templates/breadcrumb.php';

        if (file_exists($template)) {
            // Make $items available to template
            include $template;
        }
    }
}