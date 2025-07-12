<?php

namespace SimpleUserCRM\Core\Database;

defined('ABSPATH') || exit;

class DBHelper
{

    /**
     * Detect the format of the data for database operations
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
     * Insert data into a table
     */
    public static function insert(string $table, array $data): bool
    {
        global $wpdb;

        $format = self::detect_format($data);
        return (bool)$wpdb->insert($table, $data, $format);
    }

    /**
     * Update data in a table based on conditions
     */
    public static function update(string $table, array $data, array $where): bool
    {
        global $wpdb;

        $format = self::detect_format($data);
        $where_format = self::detect_format($where);

        return (bool)$wpdb->update($table, $data, $where, $format, $where_format);
    }

    /**
     * Delete data from a table based on conditions
     */
    public static function delete(string $table, array $where): bool
    {
        global $wpdb;

        $where_format = self::detect_format($where);
        return (bool)$wpdb->delete($table, $where, $where_format);
    }

    /**
     * Get a single row based on conditions
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
     * Get all rows from a table with optional conditions
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
     * Count the number of rows in a table based on conditions
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
}