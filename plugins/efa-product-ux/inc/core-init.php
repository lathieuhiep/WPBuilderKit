<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$modules_dir = EFA_PRODUCT_UX_PATH . 'modules/';
$modules = scandir( $modules_dir );

foreach ( $modules as $module ) {
    if ( $module === '.' || $module === '..' ) {
        continue;
    }

    $module_init = $modules_dir . $module . '/module.php';

    if ( file_exists( $module_init ) ) {
        require_once $module_init;
    }
}