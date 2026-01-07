<?php

namespace ExtendSite\Admin\AdminManager;

defined('ABSPATH') || exit;

final class AdminConstants
{
    public const DOMAIN = 'admin';

    /**
     * Internal parent menu slug (KHÔNG render page)
     */
    public const MENU_PARENT = 'extend_site_admin';

    /**
     * Dashboard page slug (menu cha click vào)
     */
    public const PAGE_DASHBOARD = 'extend-site-admin-dashboard';

    /**
     * Sub page prefix
     */
    public const PAGE_PREFIX = 'extend_site_admin';

    public const OPTION_PREFIX = 'extend_site_admin_';
    public const NONCE_PREFIX  = 'extend_site_admin_nonce_';
    public const CAPABILITY_MANAGE = 'manage_options';
}
