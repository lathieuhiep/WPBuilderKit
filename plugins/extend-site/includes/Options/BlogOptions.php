<?php
namespace ExtendSite\Options;

use Carbon_Fields\Field;

defined('ABSPATH') || exit;

class BlogOptions extends OptionBase {
    private const SIDEBAR_LAYOUT = 'es_opt_sidebar_layout';

    public static function fields(): array {
        return [
            // === CATEGORY ARCHIVE ===
            Field::make('separator', 'sep_category', esc_html__('Category Archive', 'extend-site')),
            Field::make('html', 'sep_category_desc')->set_html('<p class="cf-subtext">'. esc_html__( 'Sử dụng cho các trang danh mục, archive, index, tìm kiếm.', 'extend-site' ) .'</p>'),

            Field::make('select', self::SIDEBAR_LAYOUT, esc_html__('Sidebar Layout', 'extend-site'))
                ->set_options([
                    'right' => esc_html__('Right Sidebar', 'extend-site'),
                    'left'  => esc_html__('Left Sidebar', 'extend-site'),
                    'hidden'  => esc_html__('Hidden', 'extend-site'),
                ])->set_default_value('right'),
        ];
    }
}
