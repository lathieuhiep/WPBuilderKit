<?php
// Simple products
add_filter( 'woocommerce_quantity_input_args', 'basictheme_woo_quantity_input_args', 10, 2 );
function basictheme_woo_quantity_input_args( $args, $product ): array
{
    $args['classes'][] = 'custom-qty-input';

    return $args;
}

// Variations
add_filter( 'woocommerce_available_variation', 'basictheme_woo_available_variation' );
function basictheme_woo_available_variation( $args ): array
{
    $args['classes'][] = 'custom-qty-input';

    return $args;
}

// add button quantity minus
add_action( 'woocommerce_before_quantity_input_field', 'basictheme_woo_quantity_minus_button' );
function basictheme_woo_quantity_minus_button(): void
{
?>
    <button type="button" class="qty-btn qty-minus">
        <i class="ic-mask ic-mask-minus"></i>
    </button>
<?php
}

// add button quantity plus
add_action( 'woocommerce_after_quantity_input_field', 'basictheme_woo_quantity_plus_button' );
function basictheme_woo_quantity_plus_button(): void
{
?>
    <button type="button" class="qty-btn qty-plus">
        <i class="ic-mask ic-mask-plus"></i>
    </button>
<?php
}

add_filter( 'woocommerce_product_single_add_to_cart_text', '__return_empty_string' );