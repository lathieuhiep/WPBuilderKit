<?php

namespace SimpleUserCRM\Admin;

use SimpleUserCRM\Constants\PluginConstants;

class Layout
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);

        ob_start();
        include PluginConstants::path() . "admin/view/pages/{$view}.php";
        $content = ob_get_clean();

        include PluginConstants::path() . 'admin/view/layout/layout.php';
    }
}