<?php

use ExtendSite\Options\FooterOptions;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// column width
function basictheme_column_width_fields($min = 1, $max = 12, $sm = 12, $md = 6, $lg = 3, $xl = 3): array
{
    return [
        [
            'id'      => 'sm',
            'type'    => 'slider',
            'title'   => esc_html__( 'sm: ≥576px', 'basictheme' ),
            'default' => $sm,
            'min'     => $min,
            'max'     => $max,
        ],

        [
            'id'      => 'md',
            'type'    => 'slider',
            'title'   => esc_html__( 'md: ≥768px', 'basictheme' ),
            'default' => $md,
            'min'     => $min,
            'max'     => $max,
        ],

        [
            'id'      => 'lg',
            'type'    => 'slider',
            'title'   => esc_html__( 'lg: ≥992px', 'basictheme' ),
            'default' => $lg,
            'min'     => $min,
            'max'     => $max,
        ],

        [
            'id'      => 'xl',
            'type'    => 'slider',
            'title'   => esc_html__( 'xl: ≥1200px', 'basictheme' ),
            'default' => $xl,
            'min'     => $min,
            'max'     => $max,
        ],
    ];
}

// get responsive row class
function basictheme_get_responsive_row_class($per_row): string
{
    if ( empty( $per_row ) || ! is_array( $per_row ) ) {
        $per_row = [
            'sm' => 2,
            'md' => 2,
            'lg' => 3,
            'xl' => 3
        ];
    }

    return sprintf(
        'theme-row-cols-1 theme-row-cols-sm-%s theme-row-cols-md-%s theme-row-cols-lg-%s theme-row-cols-xl-%s',
        $per_row['sm'],
        $per_row['md'],
        $per_row['lg'],
        $per_row['xl']
    );
}

// get footer sidebar columns count
function basictheme_get_footer_sidebar_columns_count (): int
{
    return basictheme_opt(FooterOptions::class)->get_footer_sidebar_columns_count() ?? 4;
}