<?php
namespace SimpleUserCRM\Core;

use SimpleUserCRM\Core\Form\User\UserFormHandler;

defined('ABSPATH') || exit;

class CoreLoader
{
    // Boot up all core modules
    public static function boot(): void
    {
        // load helpers
        new Helpers();

        // load DB layer
        require_once Constants::path() . 'core/Database/DBHelper.php';

        // load form handler
        require_once Constants::path() . 'core/Form/BaseValidator.php';
        require_once Constants::path() . 'core/Form/User/UserValidator.php';

        (new UserFormHandler())->init();

        // register shortcodes
        ShortcodeRegistry::init();

        // inject dynamic content
        ContentInjector::init();
    }
}