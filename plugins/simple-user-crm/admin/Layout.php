<?php

namespace SimpleUserCRM\Admin;

use SimpleUserCRM\Constants\PluginConstants;

class Layout
{
    // render view page with data
    public static function render(string $view, array $data = []): void
    {
        extract($data);

        ob_start();
        include PluginConstants::path() . "admin/view/pages/{$view}.php";
        $content = ob_get_clean();

        include PluginConstants::path() . 'admin/view/layout/layout.php';
    }

    // render partial view with data
    public static function render_partial(string $path, array $data = []): void
    {
        extract($data);

        ob_start();
        include PluginConstants::path() . "admin/view/{$path}.php";
        $content = ob_get_clean();

        echo $content;
    }
}