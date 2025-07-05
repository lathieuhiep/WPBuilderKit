<?php
declare(strict_types=1);

final class EFA_Product_DB
{
    public static function create_all_tables(): void {
        require_once EFA_PRODUCT_UX_PATH . 'modules/swatches/class-efa-swatches-db.php';

        if ( class_exists( 'EFA_Swatches_DB' ) ) {
            EFA_Swatches_DB::create_tables();
        }
    }
}