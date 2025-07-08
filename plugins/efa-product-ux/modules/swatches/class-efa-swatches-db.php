<?php
declare(strict_types=1);

namespace EFA_Product_UX\Swatches;

final class EFA_Swatches_DB
{
    private const TABLE_NAME_SWATCHES_ATTR = 'efa_product_swatches_attributes';
    private const TABLE_NAME_SWATCHES_TERM_META = 'efa_product_swatches_term_meta';

    public static function create_tables(): void
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $attribute_table = $wpdb->prefix . self::TABLE_NAME_SWATCHES_ATTR;
        $term_meta_table = $wpdb->prefix . self::TABLE_NAME_SWATCHES_TERM_META;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $sql = [];

        // Create attributes table
        $sql[] = "CREATE TABLE $attribute_table (
            id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            attribute_id    BIGINT UNSIGNED NOT NULL UNIQUE,
            display_type    VARCHAR(50) NOT NULL DEFAULT 'button',
            custom_settings LONGTEXT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        // Create term meta table
        $sql[] = "CREATE TABLE $term_meta_table (
            id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            term_id       BIGINT UNSIGNED NOT NULL,
            attribute_id  BIGINT UNSIGNED NOT NULL,
            meta_key      VARCHAR(100) NOT NULL,
            meta_value    LONGTEXT NULL,
            PRIMARY KEY (id),
            KEY term_key  (term_id, meta_key),
            KEY attr_key  (attribute_id)
        ) $charset_collate;";

        // Execute the SQL queries
        foreach ($sql as $query) {
            dbDelta($query);
        }
    }

    public static function get_attribute_id_by_taxonomy(string $taxonomy): ?int
    {
        global $wpdb;

        // Chỉ xử lý taxonomy có tiền tố 'pa_'
        if (!str_starts_with($taxonomy, 'pa_')) {
            return null;
        }

        $attribute_slug = substr($taxonomy, 3); // Bỏ 'pa_' để lấy tên thật
        $table = $wpdb->prefix . 'woocommerce_attribute_taxonomies';

        $row = $wpdb->get_row($wpdb->prepare(
            "SELECT attribute_id FROM $table WHERE attribute_name = %s",
            $attribute_slug
        ));

        return $row ? (int)$row->attribute_id : null;
    }

    public static function save_swatches_attributes(int $attribute_id, string $type): void
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE_NAME_SWATCHES_ATTR;

        $existing = $wpdb->get_var(
            $wpdb->prepare("SELECT COUNT(*) FROM $table WHERE attribute_id = %d", $attribute_id)
        );

        if ($existing) {
            $wpdb->update(
                $table,
                ['display_type' => $type],
                ['attribute_id' => $attribute_id],
                ['%s'],
                ['%d']
            );
        } else {
            $wpdb->insert(
                $table,
                [
                    'attribute_id' => $attribute_id,
                    'display_type' => $type
                ],
                ['%d', '%s']
            );
        }
    }

    public static function get_display_type_swatches_attribute(int $attribute_id): string
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE_NAME_SWATCHES_ATTR;

        return $wpdb->get_var(
            $wpdb->prepare("SELECT display_type FROM $table WHERE attribute_id = %d", $attribute_id)
        ) ?: 'button';
    }

    public static function save_swatches_term_meta(int $term_id, int $attribute_id, string $meta_key, $meta_value): void
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE_NAME_SWATCHES_TERM_META;

        // Kiểm tra đã có chưa
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table WHERE term_id = %d AND attribute_id = %d AND meta_key = %s",
            $term_id,
            $attribute_id,
            $meta_key
        ));

        if ($exists) {
            $wpdb->update(
                $table,
                ['meta_value' => maybe_serialize($meta_value)],
                [
                    'term_id' => $term_id,
                    'attribute_id' => $attribute_id,
                    'meta_key' => $meta_key
                ],
                ['%s'],
                ['%d', '%d', '%s']
            );
        } else {
            $wpdb->insert(
                $table,
                [
                    'term_id' => $term_id,
                    'attribute_id' => $attribute_id,
                    'meta_key' => $meta_key,
                    'meta_value' => maybe_serialize($meta_value)
                ],
                ['%d', '%d', '%s', '%s']
            );
        }
    }

    public static function get_swatches_term_meta(int $term_id, string $meta_key)
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE_NAME_SWATCHES_TERM_META;

        $value = $wpdb->get_var($wpdb->prepare(
            "SELECT meta_value FROM $table WHERE term_id = %d AND meta_key = %s",
            $term_id,
            $meta_key
        ));

        return maybe_unserialize($value);
    }

    public static function delete_swatches_term_meta(int $term_id): void
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE_NAME_SWATCHES_TERM_META;
        $wpdb->delete($table, ['term_id' => $term_id], ['%d']);
    }

    public static function delete_swatches_by_attribute(int $attribute_id): void
    {
        global $wpdb;

        // Xóa cài đặt attribute
        $attr_table = $wpdb->prefix . self::TABLE_NAME_SWATCHES_ATTR;
        $wpdb->delete($attr_table, ['attribute_id' => $attribute_id], ['%d']);

        // Xóa metadata của tất cả term thuộc attribute này
        $term_meta_table = $wpdb->prefix . self::TABLE_NAME_SWATCHES_TERM_META;
        $wpdb->delete($term_meta_table, ['attribute_id' => $attribute_id], ['%d']);
    }

    public static function get_attributes_with_display_type(): array
    {
        global $wpdb;

        $swatch_table = $wpdb->prefix . self::TABLE_NAME_SWATCHES_ATTR;
        $swatch_map = $wpdb->get_results("SELECT attribute_id, display_type FROM {$swatch_table}", OBJECT_K);

        $label_map = efa_product_ux_swatches();

        $attributes = wc_get_attribute_taxonomies();

        $items = [];

        foreach ($attributes as $attr) {
            $id = (int) $attr->attribute_id;
            $raw_type = $swatch_map[$id]->display_type ?? '';
            $display_label = $label_map[$raw_type] ?? '—';

            $items[] = [
                'id'           => $id,
                'name'         => $attr->attribute_name,
                'label'        => $attr->attribute_label,
                'display_type' => $display_label,
            ];
        }

        return [
            'column_label' => esc_html__('Kiểu hiển thị', EFA_PRODUCT_TEXT_DOMAIN),
            'items'        => $items
        ];
    }
}