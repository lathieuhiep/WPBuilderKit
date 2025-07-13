<?php
namespace SimpleUserCRM\Core;

use SimpleUserCRM\Constants\PluginConstants;
use SimpleUserCRM\Core\Form\User\UserFormHandler;

defined('ABSPATH') || exit;

class CoreLoader
{
    // Boot up all core modules
    public static function boot(): void
    {
        // load DB layer
        require_once PluginConstants::path() . 'core/Database/DBHelper.php';

        // load form handler
        require_once PluginConstants::path() . 'core/Form/BaseValidator.php';
        require_once PluginConstants::path() . 'core/Form/User/UserValidator.php';

        (new UserFormHandler())->init();

        // register shortcodes
        ShortcodeRegistry::init();

        // inject dynamic content
        ContentInjector::init();
    }
}