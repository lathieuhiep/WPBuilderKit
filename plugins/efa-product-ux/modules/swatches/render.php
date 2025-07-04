<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Replace default <select> with label-based swatches
 */
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'efa_product_ux_render_label_swatches', 10, 2 );
function efa_product_ux_render_label_swatches( string $html, array $args ): string {
    if ( empty( $args['options'] ) || ! isset( $args['attribute'] ) ) {
        return $html;
    }

    $attribute_name = 'attribute_' . esc_attr( $args['attribute'] );
    $options = $args['options'];
    $selected = $args['selected'] ?? '';

    // Giữ lại <select> gốc để WooCommerce xử lý
    $select_html = $html; // Đừng xoá nữa

    // Thêm ul li swatch ngay sau <select>
    $swatch_html  = '<div class="efa-swatch efa-swatch-label" data-attribute_name="' . $attribute_name . '">';

    foreach ( $options as $option ) {
        $option_value = esc_attr( $option );
        $is_selected  = selected( $selected, $option, false ) ? ' is-selected' : '';

        $swatch_html .= sprintf(
            '<button class="efa-swatch-item%3$s" type="button" data-value="%1$s">%2$s</button>',
            $option_value,
            esc_html( $option ),
            $is_selected
        );
    }

    $swatch_html .= '</div>';

    return $select_html . $swatch_html;
}