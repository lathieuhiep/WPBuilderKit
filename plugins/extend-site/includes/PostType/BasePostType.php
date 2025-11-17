<?php

namespace ExtendSite\PostType;

defined('ABSPATH') || exit;

/**
 * Base class cho mọi CPT: cung cấp khung đăng ký & helper.
 */
abstract class BasePostType
{
    protected static array $registry = [];
    protected static array $templates = [];

    public const SLUG = 'item';
    public const SINGULAR = 'Item';
    public const PLURAL = 'Items';

    /** tên file template */
    public const TEMPLATE_SINGLE = '';
    public const TEMPLATE_ARCHIVE = '';
    public const TEMPLATE_TAX_CAT = '';

    protected array $args = [];

    public function __construct(array $args = [])
    {
        $this->args = $args;

        add_action('init', [$this, 'register_ctp']);

        // Registry info
        self::$registry[static::SLUG] = [
            'singular' => static::SINGULAR,
            'plural'   => static::PLURAL,
        ];

        // Tự động load template mapping nếu có
        $constants = (new \ReflectionClass($this))->getConstants();

        if (!empty($constants['TEMPLATE_SINGLE'])) {
            self::$templates[static::SLUG]['single'] = $constants['TEMPLATE_SINGLE'];
        }

        if (!empty($constants['TEMPLATE_ARCHIVE'])) {
            self::$templates[static::SLUG]['archive'] = $constants['TEMPLATE_ARCHIVE'];
        }

        if (isset($constants['TAX_SLUG']) && !empty($constants['TEMPLATE_TAX_CAT'])) {
            self::$templates[$constants['TAX_SLUG']]['taxonomy'] = $constants['TEMPLATE_TAX_CAT'];
        }
    }

    public static function get_registry(): array
    {
        return self::$registry;
    }

    public static function get_templates(): array
    {
        return self::$templates;
    }

    public function register_ctp(): void
    {
        $labels = [
            'name'               => _x(static::PLURAL, 'Post type general name', 'extend-site'),
            'singular_name'      => _x(static::SINGULAR, 'Post type singular name', 'extend-site'),
            'menu_name'          => static::PLURAL,
            'add_new'            => __('Thêm mới', 'extend-site'),
            'add_new_item'       => sprintf(__('Thêm %s', 'extend-site'), static::SINGULAR),
            'edit_item'          => sprintf(__('Chỉnh sửa %s', 'extend-site'), static::SINGULAR),
            'new_item'           => sprintf(__('Mới %s', 'extend-site'), static::SINGULAR),
            'view_item'          => sprintf(__('Xem %s', 'extend-site'), static::SINGULAR),
            'all_items'          => sprintf(__('Tất cả %s', 'extend-site'), static::PLURAL),
            'search_items'       => sprintf(__('Tìm kiếm %s', 'extend-site'), static::PLURAL),
            'not_found'          => __('Không tìm thấy.', 'extend-site'),
        ];

        $default_args = [
            'labels'       => $labels,
            'public'       => true,
            'has_archive'  => true,
            'hierarchical' => false,
            'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
            'rewrite'      => ['slug' => static::SLUG, 'with_front' => false],
            'menu_icon'    => 'dashicons-portfolio',
        ];

        register_post_type(static::SLUG, array_replace_recursive($default_args, $this->args));

        // Flag flush rewrite
        $this->mark_rewrite_flush_needed();
    }

    /**
     * Đăng ký taxonomy cho CPT.
     */
    protected function register_taxonomy(string $tax_slug, string $singular, string $plural, array $args = []): void
    {
        $labels = [
            'name'          => $plural,
            'singular_name' => $singular,
            'menu_name'     => $plural,
            'search_items'  => sprintf(__('Tìm kiếm %s', 'extend-site'), $plural),
            'add_new_item'  => sprintf(__('Thêm %s', 'extend-site'), $singular),
        ];

        $defaults = [
            'labels'            => $labels,
            'public'            => true,
            'hierarchical'      => true,
            'show_admin_column' => true,
            'rewrite'           => ['slug' => $tax_slug, 'with_front' => false],
        ];

        register_taxonomy($tax_slug, static::SLUG, array_replace_recursive($defaults, $args));

        // Flag flush rewrite
        $this->mark_rewrite_flush_needed();
    }

    /**
     * Đánh dấu cần flush rewrite.
     */
    protected function mark_rewrite_flush_needed(): void
    {
        if (! get_option('extend_site_flush_rewrite')) {
            update_option('extend_site_flush_rewrite', 1);
        }
    }
}