<?php

namespace ExtendSite\Admin\Helpers;

defined('ABSPATH') || exit;

/**
 * Class AdminTaxFilter
 *
 * Thêm dropdown filter taxonomy cho màn danh sách của bất kỳ CPT nào.
 * Dùng trong PostType: AdminTaxFilter::register('cpt_slug', 'taxonomy_slug', 'Label');
 */
class TaxFilter
{
    /**
     * Khởi tạo filter.
     *
     * @param string $post_type Slug của CPT.
     * @param string $taxonomy  Slug taxonomy để filter.
     * @param string $all_label Nhãn "Tất cả ..." (tùy chọn).
     */
    public static function register(string $post_type, string $taxonomy, string $all_label = ''): void
    {
        add_action('admin_init', function () use ($post_type, $taxonomy, $all_label) {

            /**
             * 1) Dropdown filter hiển thị trên list table
             */
            add_action('restrict_manage_posts', function () use ($post_type, $taxonomy, $all_label) {

                $screen = get_current_screen();
                if (!$screen || $screen->post_type !== $post_type) {
                    return;
                }

                $terms = get_terms([
                    'taxonomy'   => $taxonomy,
                    'hide_empty' => false,
                ]);

                if (empty($terms) || is_wp_error($terms)) {
                    return;
                }

                $selected      = isset($_GET[$taxonomy]) ? sanitize_text_field(wp_unslash($_GET[$taxonomy])) : '';
                $label         = $all_label !== '' ? $all_label : esc_html__('Tất cả danh mục', 'extend-site');
                $label_escaped = esc_html($label);
                ?>

                <select name="<?php echo esc_attr($taxonomy); ?>" class="postform" aria-label="<?php echo esc_attr($label_escaped); ?>">
                    <option value=""><?php echo $label_escaped; ?></option>

                    <?php foreach ($terms as $term):
                        $term_name   = $term->name;
                        $term_slug   = $term->slug;
                        $count       = $term->count;
                        $is_selected = selected($selected, $term->slug, false);
                        ?>
                        <option value="<?php echo esc_attr( $term_slug ); ?>" <?php echo esc_attr( $is_selected ); ?>>
                            <?php echo esc_html( $term_name ); ?> (<?php echo esc_html( $count ); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php
            });

            /**
             * 2) Áp filter vào WP_Query admin
             */
            add_action('parse_query', function ($query) use ($post_type, $taxonomy) {

                if (!is_admin() || !$query->is_main_query()) {
                    return;
                }

                $screen = get_current_screen();
                $pt     = $query->get('post_type');

                // Chỉ áp trên đúng CPT
                if (($screen && $screen->post_type !== $post_type) && $pt !== $post_type) {
                    return;
                }

                // Nếu user chọn taxonomy ở dropdown
                if (!empty($_GET[$taxonomy])) {
                    $term = sanitize_text_field(wp_unslash($_GET[$taxonomy]));

                    $tax_query   = (array) $query->get('tax_query');
                    $tax_query[] = [
                        'taxonomy' => $taxonomy,
                        'field'    => 'slug',
                        'terms'    => $term,
                    ];

                    $query->set('tax_query', $tax_query);
                }
            });

        });
    }
}