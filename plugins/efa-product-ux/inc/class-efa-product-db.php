<?php
declare(strict_types=1);

use EFA_Product_UX\Swatches\EFA_Swatches_DB;

final class EFA_Product_DB
{
    public static function create_all_tables(): void {
        if ( class_exists( 'EFA_Swatches_DB' ) ) {
            EFA_Swatches_DB::create_tables();
        }
    }
}