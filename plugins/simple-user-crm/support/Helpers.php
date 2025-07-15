<?php

namespace SimpleUserCRM\Support;

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

    /**
     * Hiển thị HTML phân trang dạng admin, tách biệt HTML & logic
     *
     * @param int $total_items Tổng số dòng dữ liệu
     * @param int $per_page Số dòng mỗi trang (mặc định 20)
     * @param int $current_page Trang hiện tại (mặc định 1)
     */
    public static function render_admin_pagination(int $total_items, int $per_page = 20, int $current_page = 1): void
    {
        $total_pages = (int)ceil($total_items / $per_page);
        if ($total_pages < 2) {
            return;
        }

        $pagination = paginate_links([
            'base'      => add_query_arg('paged', '%#%'),
            'format'    => '',
            'prev_text' => '« Trước',
            'next_text' => 'Tiếp »',
            'total'     => $total_pages,
            'current'   => $current_page,
            'type'      => 'array',
        ]);

        if (!empty($pagination)) {
            ?>
            <div class="tablenav-pages su-crm-pagination">
                <div class="pagination-links">
                    <?php foreach ($pagination as $link) : ?>
                        <?= wp_kses_post($link); ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
    }
}