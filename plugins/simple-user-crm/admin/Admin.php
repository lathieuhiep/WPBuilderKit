<?php
namespace SimpleUserCRM\Admin;

defined('ABSPATH') || exit;

class Admin
{
    public static function init(): void
    {
        // Initialize menu page
        MenuPage::init();

        // Enqueue admin assets
        AssetsEnqueue::init();
    }
}