<?php
namespace ExtendSite\PostType;

defined('ABSPATH') || exit;

/**
 * Base class cho mọi CPT: cung cấp khung đăng ký & helper.
 * Class con chỉ cần override: SLUG, SINGULAR, PLURAL, ARGS.
 */
abstract class BasePostType
{
    /** slug post type (không quá 20 ký tự) */
    public const SLUG = 'item';

    /** tên số ít – dùng hiển thị */
    public const SINGULAR = 'Item';

    /** tên số nhiều – dùng hiển thị */
    public const PLURAL = 'Items';

    /** text domain */
    protected string $text_domain = 'extend-site';

    /** Extra args merge vào */
    protected array $args = [];

    public function __construct(array $args = [])
    {
        $this->args = $args;
        add_action('init', [$this, 'register_ctp']);
    }

    public function register_ctp(): void
    {
        $labels = [
            'name'               => _x(static::PLURAL, 'Post type general name', $this->text_domain),
            'singular_name'      => _x(static::SINGULAR, 'Post type singular name', $this->text_domain),
            'menu_name'          => _x(static::PLURAL, 'Admin Menu text', $this->text_domain),
            'name_admin_bar'     => _x(static::SINGULAR, 'Add New on Toolbar', $this->text_domain),
            'add_new'            => __('Add New', $this->text_domain),
            'add_new_item'       => sprintf(__('Add New %s', $this->text_domain), static::SINGULAR),
            'new_item'           => sprintf(__('New %s', $this->text_domain), static::SINGULAR),
            'edit_item'          => sprintf(__('Edit %s', $this->text_domain), static::SINGULAR),
            'view_item'          => sprintf(__('View %s', $this->text_domain), static::SINGULAR),
            'all_items'          => sprintf(__('All %s', $this->text_domain), static::PLURAL),
            'search_items'       => sprintf(__('Search %s', $this->text_domain), static::PLURAL),
            'parent_item_colon'  => sprintf(__('Parent %s:', $this->text_domain), static::PLURAL),
            'not_found'          => __('Not found.', $this->text_domain),
            'not_found_in_trash' => __('Not found in Trash.', $this->text_domain),
        ];

        $default_args = [
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'show_in_rest'       => false,           // Gutenberg + REST
            'hierarchical'       => false,
            'supports'           => ['title','editor','thumbnail','excerpt','revisions'],
            'menu_position'      => 20,
            'menu_icon'          => 'dashicons-portfolio',
            'rewrite'            => ['slug' => static::SLUG, 'with_front' => false],
            'capability_type'    => 'post',
        ];

        register_post_type(static::SLUG, array_replace_recursive($default_args, $this->args));
    }

    /**
     * (Tuỳ chọn) Đăng ký taxonomy đi kèm.
     */
    protected function register_taxonomy(string $tax_slug, string $singular, string $plural, array $args = []): void
    {
        $labels = [
            'name'          => _x($plural, 'taxonomy general name', $this->text_domain),
            'singular_name' => _x($singular, 'taxonomy singular name', $this->text_domain),
            'search_items'  => sprintf(__('Search %s', $this->text_domain), $plural),
            'all_items'     => sprintf(__('All %s', $this->text_domain), $plural),
            'edit_item'     => sprintf(__('Edit %s', $this->text_domain), $singular),
            'update_item'   => sprintf(__('Update %s', $this->text_domain), $singular),
            'add_new_item'  => sprintf(__('Add New %s', $this->text_domain), $singular),
            'new_item_name' => sprintf(__('New %s Name', $this->text_domain), $singular),
            'menu_name'     => $plural,
        ];

        $defaults = [
            'labels'       => $labels,
            'public'       => true,
            'hierarchical' => true,
            'show_ui'      => true,
            'show_in_rest' => true,
            'rewrite'      => ['slug' => $tax_slug, 'with_front' => false],
        ];

        register_taxonomy($tax_slug, [static::SLUG], array_replace_recursive($defaults, $args));
    }
}