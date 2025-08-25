<?php
namespace ExtendSite\PostType;

defined('ABSPATH') || exit;

class PortfolioPostType extends BasePostType
{
    public const SLUG     = 'portfolio';
    public const SINGULAR = 'Portfolio';
    public const PLURAL   = 'Portfolios';

    public function __construct(array $args = [])
    {
        parent::__construct($args);

        // Đăng ký taxonomy kèm theo (vd: portfolio_category)
        add_action('init', function () {
            $this->register_taxonomy('portfolio_category', 'Category', 'Categories', [
                'hierarchical' => true,
                'rewrite'      => ['slug' => 'portfolio-category'],
            ]);
        });

        // Tuỳ chọn: cột admin
        add_filter('manage_edit-' . self::SLUG . '_columns', [$this, 'columns']);
        add_action('manage_' . self::SLUG . '_posts_custom_column', [$this, 'render_column'], 10, 2);
    }

    public function columns($columns): array
    {
        // Giữ checkbox + title + date, chèn thêm thumbnail & taxonomy
        $new = [];
        foreach ($columns as $key => $label) {
            if ($key === 'cb') { $new[$key] = $label; continue; }

            if ($key === 'title') {
                $new['thumbnail'] = __('Thumb', 'extend-site');
                $new[$key]        = $label;
                $new['portfolio_category'] = __('Category', 'extend-site');
            } else {
                $new[$key] = $label;
            }
        }
        return $new;
    }

    public function render_column(string $column, int $post_id): void
    {
        if ($column === 'thumbnail') {
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, [60,60]);
            } else {
                echo '—';
            }
        }

        if ($column === 'portfolio_category') {
            $terms = get_the_term_list($post_id, 'portfolio_category', '', ', ');
            echo $terms ? $terms : '—';
        }
    }
}