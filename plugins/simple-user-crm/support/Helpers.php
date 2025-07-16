<?php

namespace SimpleUserCRM\Support;

use SimpleUserCRM\Constants\PluginConstants;
use SimpleUserCRM\Core\Database\DBHelper;

class Helpers
{
    // format phone number to remove non-numeric characters
    public static function normalize_phone(string $phone): string
    {
        return preg_replace('/\D+/', '', $phone);
    }

    // check if a phone number is valid according to Vietnamese standards
    public static function is_valid_vn_phone(string $phone): bool
    {
        $phone = self::normalize_phone($phone);

        // Chỉ chấp nhận 9–10 số, bắt đầu bằng 0
        if (!preg_match('/^0\d{8,9}$/', $phone)) {
            return false;
        }

        // Từ chối số toàn 1 ký tự (vd: 0000000000)
        if (preg_match('/^(\d)\1{8,9}$/', $phone)) {
            return false;
        }

        return true;
    }

    //
    public static function is_check_date_format($value): bool
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $value);
    }

    // check if a field value is unique in the table
    public static function is_unique(string $field, string $value, $table): bool
    {
        $row = DBHelper::get_row($table, [$field => $value]);

        return $row === null;
    }

    // get pagination data
    public static function get_pagination_data(int $total_items, int $default_per_page = PluginConstants::KEY_LIMIT_PER_PAGE): array
    {
        $per_page = $default_per_page;
        $current_page = isset($_GET['paged']) ? max(1, (int)$_GET['paged']) : 1;
        $offset = ($current_page - 1) * $per_page;
        $total_pages = (int)ceil($total_items / $per_page);

        return compact('per_page', 'current_page', 'offset', 'total_pages');
    }

    /**
     * Hiển thị HTML phân trang dạng admin, tách biệt HTML & logic
     *
     * @param int $total_pages
     * @param int $current_page
     * @return void
     */
    public static function render_admin_pagination_links(int $total_pages, int $current_page): void
    {
        if ($total_pages < 2) {
            return;
        }

        $base_args = $_GET;
        $base_args['paged'] = '%#%';

        $safe_args = array_map('sanitize_text_field', $base_args);

        $pagination = paginate_links([
            'base' => add_query_arg($safe_args),
            'format' => '',
            'prev_text' => esc_html__('Trước', PluginConstants::TEXT_DOMAIN),
            'next_text' => esc_html__('Sau', PluginConstants::TEXT_DOMAIN),
            'total' => $total_pages,
            'current' => $current_page,
            'type' => 'array',
        ]);

        if (!empty($pagination)) :
        ?>
            <div class="su-crm-pagination">
                <?php
                foreach ($pagination as $link) :
                    echo wp_kses_post($link);
                endforeach;
                ?>
            </div>
        <?php
        endif;
    }
}