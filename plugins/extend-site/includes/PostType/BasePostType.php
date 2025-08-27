<?php

namespace ExtendSite\PostType;

defined('ABSPATH') || exit;

/**
 * Base class cho mọi CPT: cung cấp khung đăng ký & helper.
 * Class con chỉ cần override: SLUG, SINGULAR, PLURAL, ARGS.
 */
abstract class BasePostType
{
    /** @var array Lưu trữ danh sách các loại post type đã đăng ký */
    protected static array $registry = [];

    /** @var array Lưu trữ danh sách các template cần tải */
    protected static array $templates = [];

    /** slug post type (không quá 20 ký tự) */
    public const SLUG = 'item';

    /** tên số ít – dùng hiển thị */
    public const SINGULAR = 'Item';

    /** tên số nhiều – dùng hiển thị */
    public const PLURAL = 'Items';

    /** tên file */
    public const TEMPLATE_SINGLE = '';
    public const TEMPLATE_ARCHIVE = '';
    public const TEMPLATE_TAX_CAT = '';

    /** Extra args merge vào */
    protected array $args = [];

    public function __construct(array $args = [])
    {
        $this->args = $args;
        add_action('init', [$this, 'register_ctp']);

        // Tự động đăng ký thông tin post type và template
        self::$registry[static::SLUG] = [
            'singular' => static::SINGULAR,
            'plural' => static::PLURAL,
        ];

        // Lấy danh sách template từ lớp con nếu có
        $reflection = new \ReflectionClass($this);
        $constants = $reflection->getConstants();

        if (!empty($constants['TEMPLATE_SINGLE'])) {
            self::$templates[static::SLUG]['single'] = $constants['TEMPLATE_SINGLE'];
        }
        if (!empty($constants['TEMPLATE_ARCHIVE'])) {
            self::$templates[static::SLUG]['archive'] = $constants['TEMPLATE_ARCHIVE'];
        }
        if (!empty($constants['TEMPLATE_TAX_CAT'])) {
            self::$templates[static::TAX_SLUG]['taxonomy'] = $constants['TEMPLATE_TAX_CAT'];
        }
    }

    /**
     * Lấy danh sách post type đã đăng ký.
     */
    public static function get_registry(): array
    {
        return self::$registry;
    }

    /**
     * Lấy danh sách các template đã đăng ký.
     */
    public static function get_templates(): array
    {
        return self::$templates;
    }

    public function register_ctp(): void
    {
        $labels = [
            'name' => _x(static::PLURAL, 'Post type general name', 'extend-site'),
            'singular_name' => _x(static::SINGULAR, 'Post type singular name', 'extend-site'),
            'menu_name' => _x(static::PLURAL, 'Admin Menu text', 'extend-site'),
            'name_admin_bar' => _x(static::SINGULAR, 'Add New on Toolbar', 'extend-site'),
            'add_new' => esc_html__('Add New', 'extend-site'),
            'add_new_item' => sprintf(__('Add New %s', 'extend-site'), static::SINGULAR),
            'new_item' => sprintf(__('New %s', 'extend-site'), static::SINGULAR),
            'edit_item' => sprintf(__('Edit %s', 'extend-site'), static::SINGULAR),
            'view_item' => sprintf(__('View %s', 'extend-site'), static::SINGULAR),
            'all_items' => sprintf(__('All %s', 'extend-site'), static::PLURAL),
            'search_items' => sprintf(__('Search %s', 'extend-site'), static::PLURAL),
            'parent_item_colon' => sprintf(__('Parent %s:', 'extend-site'), static::PLURAL),
            'not_found' => esc_html__('Not found.', 'extend-site'),
            'not_found_in_trash' => esc_html__('Not found in Trash.', 'extend-site'),
        ];

        $default_args = [
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => false,           // Gutenberg + REST
            'hierarchical' => false,
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'author', 'revisions'],
            'menu_position' => 20,
            'menu_icon' => 'dashicons-portfolio',
            'rewrite' => ['slug' => static::SLUG, 'with_front' => false],
            'capability_type' => 'post',
        ];

        register_post_type(static::SLUG, array_replace_recursive($default_args, $this->args));
    }

    /**
     * (Tuỳ chọn) Đăng ký taxonomy đi kèm.
     */
    protected function register_taxonomy(string $tax_slug, string $singular, string $plural, array $args = []): void
    {
        $labels = [
            'name' => _x($plural, 'taxonomy general name', 'extend-site'),
            'singular_name' => _x($singular, 'taxonomy singular name', 'extend-site'),
            'search_items' => sprintf(__('Search %s', 'extend-site'), $plural),
            'all_items' => sprintf(__('All %s', 'extend-site'), $plural),
            'edit_item' => sprintf(__('Edit %s', 'extend-site'), $singular),
            'update_item' => sprintf(__('Update %s', 'extend-site'), $singular),
            'add_new_item' => sprintf(__('Add New %s', 'extend-site'), $singular),
            'new_item_name' => sprintf(__('New %s Name', 'extend-site'), $singular),
            'menu_name' => $plural,
        ];

        $defaults = [
            'labels' => $labels,
            'public' => true,
            'hierarchical' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'rewrite' => ['slug' => $tax_slug, 'with_front' => false],
            'show_admin_column' => true,
        ];

        register_taxonomy($tax_slug, [static::SLUG], array_replace_recursive($defaults, $args));
    }
}