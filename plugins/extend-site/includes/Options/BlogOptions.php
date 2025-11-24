<?php

namespace ExtendSite\Options;

use Carbon_Fields\Field;

defined('ABSPATH') || exit;

class BlogOptions extends OptionBase
{
    // key options
    private const SIDEBAR_LAYOUT = 'es_opt_post_cat_sidebar_layout';
    private const SIDEBAR_LAYOUT_RIGHT = 'right';
    private const SIDEBAR_LAYOUT_LEFT = 'left';
    private const SIDEBAR_LAYOUT_HIDDEN = 'hidden';
    private const POST_COL_SM = 'es_opt_post_col_sm';
    private const POST_COL_MD = 'es_opt_post_col_md';
    private const POST_COL_LG = 'es_opt_post_col_lg';
    private const POST_COL_XL = 'es_opt_post_col_xl';


    // option fields
    public static function fields(): array
    {
        return [
            // ========================
            // === CATEGORY ARCHIVE ===
            // ========================
            Field::make('separator', 'sep_category', esc_html__('Category and Archive Pages', 'extend-site')),

            Field::make('html', 'sep_category_desc')
                ->set_html('<p class="cf-subtext">' . esc_html__(
                        'Applied to category archives, general archives, index pages, and search results.',
                        'extend-site'
                    ) . '</p>'),

            // Sidebar Layout
            Field::make('select', self::SIDEBAR_LAYOUT, esc_html__('Sidebar Layout', 'extend-site'))
                ->set_options([
                    self::SIDEBAR_LAYOUT_RIGHT => esc_html__('Right Sidebar', 'extend-site'),
                    self::SIDEBAR_LAYOUT_LEFT => esc_html__('Left Sidebar', 'extend-site'),
                    self::SIDEBAR_LAYOUT_HIDDEN => esc_html__('No Sidebar', 'extend-site'),
                ])->set_default_value(self::SIDEBAR_LAYOUT_RIGHT),

            // Columns per Breakpoint
            Field::make( 'html', 'crb_information_text' )
                ->set_html( '<h4>'. esc_html__( 'Archive Grid Columns per Breakpoint', 'extend-site' ) .'</h4>' ),

            Field::make('text', self::POST_COL_SM, esc_html__('sm: ≥576px', 'extend-site'))
                ->set_attribute('type', 'number')
                ->set_attribute('min', 1)
                ->set_attribute('max', 12)
                ->set_attribute('step', 1)
                ->set_default_value(2)
                ->set_width(25),

            Field::make('text', self::POST_COL_MD, esc_html__('md: ≥768px', 'extend-site'))
                ->set_attribute('type', 'number')
                ->set_attribute('min', 1)
                ->set_attribute('max', 12)
                ->set_attribute('step', 1)
                ->set_default_value(2)
                ->set_width(25),

            Field::make('text', self::POST_COL_LG, esc_html__('lg: ≥992px', 'extend-site'))
                ->set_attribute('type', 'number')
                ->set_attribute('min', 1)
                ->set_attribute('max', 12)
                ->set_attribute('step', 1)
                ->set_default_value(3)
                ->set_width(25),

            Field::make('text', self::POST_COL_XL, esc_html__('xl: ≥1200px', 'extend-site'))
                ->set_attribute('type', 'number')
                ->set_attribute('min', 1)
                ->set_attribute('max', 12)
                ->set_attribute('step', 1)
                ->set_default_value(3)
                ->set_width(25),

            // ========================
            // ======== SINGLE ========
            // ========================
        ];
    }

    // get sidebar layout for archive pages
    public function get_sidebar_layout_archive(string $default = self::SIDEBAR_LAYOUT_RIGHT): string
    {
        $value = self::get(self::SIDEBAR_LAYOUT, $default);

        return !empty($value) ? $value : $default;
    }

    // get archive row classes
    public function get_archive_row_columns(): array
    {
        return [
            'sm' => (int) self::get(self::POST_COL_SM, 2),
            'md' => (int) self::get(self::POST_COL_MD, 2),
            'lg' => (int) self::get(self::POST_COL_LG, 3),
            'xl' => (int) self::get(self::POST_COL_XL, 3),
        ];
    }
}
