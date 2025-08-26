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

        es_add_custom_taxonomy_filter_to_cpt('portfolio', 'portfolio_category');
    }
}