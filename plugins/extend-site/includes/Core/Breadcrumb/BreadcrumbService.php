<?php

namespace ExtendSite\Core\Breadcrumb;

use ExtendSite\Admin\AdminManager\Modules\BreadcrumbAdmin;
use ExtendSite\Core\Breadcrumb\Renderer\HtmlRenderer;
use ExtendSite\Core\Breadcrumb\Renderer\JsonLdRenderer;

defined('ABSPATH') || exit;

final class BreadcrumbService
{
    private static ?self $instance = null;
    private BreadcrumbManager $manager;

    // Separator string
    private string $separator = '>';

    /**
     * Private constructor for singleton.
     */
    private function __construct()
    {
        $this->manager = new BreadcrumbManager();
    }

    /**
     * Get singleton instance.
     */
    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Boot breadcrumb service (register hooks).
     */
    public function boot(): void
    {
        $this->load_config();

        // Register hooks
        add_action('wp_head', [$this, 'render_schema'], 20);
        add_shortcode('extend_site_breadcrumb', [$this, 'shortcode']);

        add_action('save_post', [$this, 'clear_post_cache']);
        add_action('created_term', [$this, 'clear_term_cache']);
        add_action('edited_term', [$this, 'clear_term_cache']);
        add_action('delete_term', [$this, 'clear_term_cache']);
    }

    /**
     * Load configuration from admin settings.
     */
    private function load_config(): void
    {
        $admin = new BreadcrumbAdmin();
        $this->separator = $admin->get_separator();
    }

    // -------- Get option --------

    /**
     * Get separator string.
     */
    public function get_separator(): string
    {
        return $this->separator;
    }

    // -------- Render HTML --------

    /**
     * Public: render breadcrumb HTML.
     */
    public function render(): void
    {
        $items = $this->manager->get_items();

        if (!$items) {
            return;
        }

        // Prepare data
        $data = [
            'items' => $items,
            'options' => [
                'separator' => $this->get_separator(),
            ],
        ];

        // Render HTML
        (new HtmlRenderer())->render($data);
    }

    /**
     * Public: get breadcrumb items.
     */
    public function get_items(): array
    {
        return $this->manager->get_items();
    }

    /**
     * Render JSON-LD schema.
     */
    public function render_schema(): void
    {
        if (is_admin()) {
            return;
        }

        $items = $this->get_items();
        if (empty($items)) {
            return;
        }

        (new JsonLdRenderer())->render($items);
    }

    /**
     * Get breadcrumb HTML for shortcode.
     */
    public function shortcode(): string
    {
        ob_start();

        $this->render();

        return ob_get_clean();
    }

    /**
     * Clear cache for post.
     */
    public function clear_post_cache(int $post_id): void
    {
        if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
            return;
        }

        wp_cache_delete('es_bc_' . $post_id, 'extend-site');
    }

    /**
     * Clear cache for term.
     */
    public function clear_term_cache(int $term_id): void
    {
        wp_cache_delete('es_bc_term_' . $term_id, 'extend-site');
    }
}