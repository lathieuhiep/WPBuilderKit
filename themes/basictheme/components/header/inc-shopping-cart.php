<?php
$cart = basictheme_get_option( 'opt_menu_cart', '1' );

if ( class_exists( 'Woocommerce' ) && $cart == '1' && ! is_cart() && ! is_checkout() ) :
?>
    <div class="widget-cart-warp d-flex align-items-center">
        <?php
        do_action( 'basictheme_woo_shopping_cart' );

        the_widget( 'WC_Widget_Cart', '' );
        ?>
    </div>
<?php endif; ?>