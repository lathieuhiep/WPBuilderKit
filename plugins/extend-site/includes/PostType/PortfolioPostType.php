<?php

namespace ExtendSite\PostType;

use ExtendSite\Admin\Helpers\TaxFilter;

defined('ABSPATH') || exit;

class PortfolioPostType extends BasePostType
{
    public const SLUG = 'portfolio';
    public const TAX_SLUG = 'portfolio_category';

    public const SINGULAR = 'Portfolio';
    public const PLURAL = 'Portfolios';
    public const TAX_NAME = 'Danh mục Portfolio';

    public const TEMPLATE_SINGLE = 'single-portfolio.php';
    public const TEMPLATE_ARCHIVE = 'archive-portfolio.php';
    public const TEMPLATE_TAX_CAT = 'taxonomy-portfolio-category.php';

    public function __construct(array $args = [])
    {
        parent::__construct($args);

        // Đăng ký taxonomy
        add_action('init', function () {
            $this->register_taxonomy(
                self::TAX_SLUG,
                'Danh mục',
                'Danh mục',
                [
                    'hierarchical' => true,
                    'rewrite' => ['slug' => 'portfolio-category'],
                ]
            );
        });

        // Đăng ký bộ lọc taxonomy trong admin
        TaxFilter::register(self::SLUG, self::TAX_SLUG);
    }
}