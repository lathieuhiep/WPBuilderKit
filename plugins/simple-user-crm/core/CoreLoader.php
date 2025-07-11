<?php
namespace SimpleUserCRM\Core;

defined('ABSPATH') || exit;

class CoreLoader
{
    // Boot up all core modules
    public static function boot(): void
    {
        // load helpers
        new Helpers();

        // register shortcodes
        ShortcodeRegistry::init();

        // inject dynamic content
        ContentInjector::init();
    }
}