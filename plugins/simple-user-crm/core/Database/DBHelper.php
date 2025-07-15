<?php

namespace SimpleUserCRM\Core\Database;

defined('ABSPATH') || exit;

class DBHelper
{

    /**
     * Tự động xác định định dạng dữ liệu (%d, %f, %s) cho từng giá trị trong mảng.
     *
     * @param array $data Mảng dữ liệu
     * @return array Mảng định dạng tương ứng, dùng cho các hàm insert/update của $wpdb
     *
     * @example
     * detect_format(['id' => 123, 'name' => 'A']) → ['%d', '%s']
     */

    protected static function detect_format(array $data): array
    {
        $format = [];

        foreach ($data as $value) {
            if (is_int($value)) {
                $format[] = '%d';
            } elseif (is_float($value)) {
                $format[] = '%f';
            } else {
                $format[] = '%s';
            }
        }

        return $format;
    }

    /**
     * Thêm một bản ghi mới vào bảng trong cơ sở dữ liệu.
     *
     * Tự động xác định định dạng (%s, %d, ...) của từng trường.
     *
     * @param string $table Tên bảng (bao gồm prefix, ví dụ: $wpdb->prefix . 'su_crm_users')
     * @param array  $data  Mảng dữ liệu dạng ['column_name' => value]
     *
     * @return bool True nếu thêm thành công, False nếu thất bại
     *
     * @example
     * DBHelper::insert($table, [
     *     'full_name' => 'Nguyễn Văn A',
     *     'email' => 'a@gmail.com',
     *     'status' => 'active'
     * ]);
     */
    public static function insert(string $table, array $data): bool
    {
        global $wpdb;

        $format = self::detect_format($data);
        return (bool)$wpdb->insert($table, $data, $format);
    }

    /**
     * Cập nhật một hoặc nhiều bản ghi trong bảng dựa theo điều kiện.
     *
     * @param string $table Tên bảng
     * @param array  $data  Dữ liệu cập nhật: ['column' => value]
     * @param array  $where Điều kiện cập nhật: ['column' => value]
     *
     * @return bool True nếu cập nhật thành công, False nếu thất bại
     *
     * @example
     * DBHelper::update($table, ['status' => 'inactive'], ['email' => 'a@gmail.com']);
     */
    public static function update(string $table, array $data, array $where): bool
    {
        global $wpdb;

        $format = self::detect_format($data);
        $where_format = self::detect_format($where);

        return (bool)$wpdb->update($table, $data, $where, $format, $where_format);
    }

    /**
     * Xóa bản ghi khỏi bảng dựa trên điều kiện cho trước.
     *
     * @param string $table Tên bảng
     * @param array  $where Điều kiện xóa: ['column' => value]
     *
     * @return bool True nếu xóa thành công, False nếu thất bại
     *
     * @example
     * DBHelper::delete($table, ['email' => 'a@gmail.com']);
     */
    public static function delete(string $table, array $where): bool
    {
        global $wpdb;

        $where_format = self::detect_format($where);
        return (bool)$wpdb->delete($table, $where, $where_format);
    }

    /**
     * Lấy 1 dòng dữ liệu duy nhất thỏa điều kiện.
     * Dùng cho truy vấn đơn (chi tiết người dùng, tra ID, kiểm tra tồn tại...)
     *
     * @param string $table   Tên bảng cần truy vấn
     * @param array  $where   Mảng điều kiện: ['column' => value]
     *                        Mặc định so sánh bằng (=), kết hợp AND
     * @param string $columns Các cột muốn lấy (mặc định '*')
     *
     * @return array|null Mảng kết quả liên hợp nếu tìm thấy, null nếu không có
     *
     * @example
     * DBHelper::get_row($table, ['email' => 'a@gmail.com']);
     */
    public static function get_row(string $table, array $where, string $columns = '*'): ?array
    {
        global $wpdb;

        $conditions = [];
        $values = [];

        foreach ($where as $key => $val) {
            $conditions[] = "$key = %s";
            $values[] = $val;
        }

        $sql = "SELECT $columns FROM $table WHERE " . implode(' AND ', $conditions) . " LIMIT 1";
        return $wpdb->get_row($wpdb->prepare($sql, ...$values), ARRAY_A) ?: null;
    }

    /**
     * Lấy toàn bộ dữ liệu từ bảng (không phân trang).
     *
     * Không nên dùng cho bảng lớn (trên 5000 dòng), thay bằng get_advanced_slice().
     *
     * @param string $table   Tên bảng cần truy vấn
     * @param array  $where   (Tùy chọn) Mảng điều kiện: ['column' => value]
     * @param string $columns Các cột muốn lấy (mặc định '*')
     *
     * @return array Mảng kết quả (mỗi phần tử là 1 dòng dạng assoc)
     *
     * @example
     * DBHelper::get_all($table, ['status' => 'active']);
     */
    public static function get_all(string $table, array $where = [], string $columns = '*'): array
    {
        global $wpdb;

        $sql = "SELECT $columns FROM $table";
        $values = [];

        if (!empty($where)) {
            $conditions = [];
            foreach ($where as $key => $val) {
                $conditions[] = "$key = %s";
                $values[] = $val;
            }
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        return $wpdb->get_results($wpdb->prepare($sql, ...$values), ARRAY_A) ?: [];
    }

    /**
     * Đếm tổng số bản ghi thỏa điều kiện trong bảng.
     *
     * Dùng khi không cần lọc nâng cao (chỉ so sánh bằng).
     *
     * @param string $table Tên bảng
     * @param array  $where Mảng điều kiện: ['column' => value]
     *
     * @return int Tổng số bản ghi phù hợp
     *
     * @example
     * DBHelper::count($table, ['status' => 'active']);
     */
    public static function count(string $table, array $where = []): int
    {
        global $wpdb;

        if (empty($where)) {
            return (int)$wpdb->get_var("SELECT COUNT(*) FROM $table");
        }

        $conditions = [];
        $values = [];

        foreach ($where as $key => $val) {
            $conditions[] = "$key = %s";
            $values[] = $val;
        }

        $sql = "SELECT COUNT(*) FROM $table WHERE " . implode(' AND ', $conditions);
        return (int)$wpdb->get_var($wpdb->prepare($sql, ...$values));
    }

    /**
     * Tạo chuỗi WHERE và giá trị chuẩn bị cho truy vấn nâng cao
     *
     * @param array $where Mảng điều kiện nâng cao. Cấu trúc:
     *     [
     *         ['column' => string, 'op' => string, 'value' => mixed],
     *         ...
     *     ]
     * @return array [
     *     'sql' => string câu điều kiện WHERE (không gồm chữ "WHERE"),
     *     'values' => array các giá trị cần binding vào prepare()
     * ]
     */
    protected static function build_advanced_where_clause(array $where): array
    {
        $conditions = [];
        $values = [];

        foreach ($where as $cond) {
            $col = $cond['column'];
            $op  = strtoupper($cond['op'] ?? '=');
            $val = $cond['value'] ?? null;

            switch ($op) {
                case 'IN':
                case 'NOT IN':
                    if (is_array($val) && count($val)) {
                        $placeholders = implode(',', array_fill(0, count($val), '%s'));
                        $conditions[] = "$col $op ($placeholders)";
                        $values = array_merge($values, $val);
                    }
                    break;

                case 'BETWEEN':
                    if (is_array($val) && count($val) === 2) {
                        $conditions[] = "$col BETWEEN %s AND %s";
                        $values[] = $val[0];
                        $values[] = $val[1];
                    }
                    break;

                case 'IS NULL':
                case 'IS NOT NULL':
                    $conditions[] = "$col $op";
                    break;

                default: // =, !=, <, >, LIKE, ...
                    $conditions[] = "$col $op %s";
                    $values[] = $val;
                    break;
            }
        }

        return [
            'sql' => implode(' AND ', $conditions),
            'values' => $values
        ];
    }

    /**
     * Đếm tổng số bản ghi theo điều kiện nâng cao.
     * Sử dụng cùng cấu trúc WHERE với get_advanced_slice().
     *
     * @param string $table
     * @param array $where (mảng điều kiện nâng cao, giống build_advanced_where_clause)
     * @return int
     */
    public static function count_advanced(string $table, array $where = []): int
    {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM $table";
        $clause = self::build_advanced_where_clause($where);

        if ($clause['sql']) {
            $sql .= ' WHERE ' . $clause['sql'];
        }

        return (int) $wpdb->get_var($wpdb->prepare($sql, ...$clause['values']));
    }

    /**
     * Truy vấn dữ liệu dạng phân trang với điều kiện nâng cao (support WHERE + LIMIT + OFFSET)
     *
     * Hỗ trợ các toán tử: =, !=, <, >, <=, >=, LIKE, NOT LIKE, IN, NOT IN, BETWEEN, IS NULL, IS NOT NULL
     *
     * @param string $table     Tên bảng cần truy vấn
     * @param array  $where     Mảng điều kiện nâng cao. Mỗi phần tử gồm:
     *                          [
     *                              'column' => string,
     *                              'op'     => string,      // toán tử SQL (mặc định '=')
     *                              'value'  => mixed        // giá trị (chuỗi, số, mảng nếu IN/BETWEEN)
     *                          ]
     * @param string $columns   Các cột cần lấy (mặc định '*')
     * @param int    $limit     Số bản ghi mỗi trang (mặc định 20)
     * @param int    $offset    Vị trí bắt đầu (offset) (mặc định 0)
     * @param string $order_by  Câu sắp xếp SQL (mặc định 'id DESC')
     *
     * @return array Mảng kết quả dạng liên hợp (assoc)
     *
     * @example
     * $where = [
     *     ['column' => 'status', 'op' => '=', 'value' => 'active'],
     *     ['column' => 'email', 'op' => 'LIKE', 'value' => '%gmail.com'],
     *     ['column' => 'created_at', 'op' => 'BETWEEN', 'value' => ['2024-01-01', '2024-12-31']]
     * ];
     *
     * $users = DBHelper::get_advanced_slice('wp_su_crm_users', $where, '*', 20, 40, 'created_at DESC');
     */
    public static function get_advanced_slice(
        string $table,
        array $where = [],
        string $columns = '*',
        int $limit = 20,
        int $offset = 0,
        string $order_by = 'id DESC'
    ): array {
        global $wpdb;

        $sql = "SELECT $columns FROM $table";
        $clause = self::build_advanced_where_clause($where);

        if ($clause['sql']) {
            $sql .= ' WHERE ' . $clause['sql'];
        }

        if (!empty($order_by)) {
            $sql .= " ORDER BY $order_by";
        }

        $sql .= " LIMIT %d OFFSET %d";
        $values = array_merge($clause['values'], [$limit, $offset]);

        return $wpdb->get_results($wpdb->prepare($sql, ...$values), ARRAY_A) ?: [];
    }
}