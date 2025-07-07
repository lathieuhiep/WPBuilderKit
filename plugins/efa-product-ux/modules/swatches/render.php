<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

use EFA_Product_UX\Swatches\EFA_Swatches_DB;

/**
 * Replace default <select> with label-based swatches
 */
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'efa_product_ux_render_label_swatches', 10, 2);
function efa_product_ux_render_label_swatches(string $html, array $args): string
{
    if (empty($args['options']) || !isset($args['attribute'])) {
        return $html;
    }

    $taxonomy = $args['attribute'];
    $attribute_name = 'attribute_' . esc_attr($taxonomy);
    $options = $args['options'];
    $selected = $args['selected'] ?? '';
    $product = $args['product'];

    $attribute_id = EFA_Swatches_DB::get_attribute_id_by_taxonomy($taxonomy);
    $display_type = $attribute_id ? EFA_Swatches_DB::get_display_type_swatches_attribute($attribute_id) : null;

    if (!$display_type) $display_type = 'button';
    $terms = wc_get_product_terms($product->get_id(), $taxonomy, ['fields' => 'all']);

    // Giữ lại <select> gốc để WooCommerce xử lý
    $select_html = $html;

    // Thêm ul li swatch ngay sau <select>
    $swatch_html = '<div class="efa-swatch efa-swatch-label" data-attribute_name="' . $attribute_name . '">';

    if (!empty($terms)) {
        foreach ($terms as $term) {
            $slug = esc_attr($term->slug);
            $label = esc_html($term->name);
            $is_selected = selected($selected, $term->slug, false) ? ' is-selected' : '';

            switch ($display_type) {
                case 'color':
                    $color = EFA_Swatches_DB::get_swatches_term_meta($term->term_id, 'color');

                    if ($color) :
                        $swatch_html .= sprintf(
                            '<button class="efa-swatch-item%3$s item-color" type="button" data-value="%1$s" title="%1$s">
                                        <span class="custom-attribute" style="background:%2$s"></span>
                                    </button>',
                            $slug,
                            esc_attr($color),
                            $is_selected
                        );
                    else :
                        $swatch_html .= sprintf(
                            '<button class="efa-swatch-item%2$s item-btn" type="button" data-value="%1$s">%1$s</button>',
                            $slug,
                            $is_selected
                        );
                    endif;

                    break;

                case 'image':
                    $img_id = EFA_Swatches_DB::get_swatches_term_meta($term->term_id, 'image');
                    if ($img_id) {
                        $img_html = wp_get_attachment_image($img_id, 'thumbnail', false, ['alt' => $label]);
                        $swatch_html .= sprintf(
                            '<button class="efa-swatch-item%2$s" type="button" data-value="%1$s">%3$s</button>',
                            $slug,
                            $is_selected,
                            $img_html
                        );
                    } else {
                        $swatch_html .= sprintf(
                            '<button class="efa-swatch-item%2$s item-btn" type="button" data-value="%1$s">%1$s</button>',
                            $slug,
                            $is_selected
                        );
                    }
                    break;

                case 'button':
                default:
                    $meta_label = EFA_Swatches_DB::get_swatches_term_meta($term->term_id, 'button');
                    $label = $meta_label ?: $label ?: $slug;
                    $swatch_html .= sprintf(
                        '<button class="efa-swatch-item%3$s item-btn" type="button" data-value="%1$s">%2$s</button>',
                        $slug,
                        $label,
                        $is_selected
                    );
                    break;
            }
        }
    } else {
        foreach ($options as $option) {
            $option_value = esc_attr($option);
            $is_selected = selected($selected, $option, false) ? ' is-selected' : '';

            $swatch_html .= sprintf(
                '<button class="efa-swatch-item%3$s" type="button" data-value="%1$s">%2$s</button>',
                $option_value,
                esc_html($option),
                $is_selected
            );
        }
    }

    $swatch_html .= '</div>';

    return $select_html . $swatch_html;
}