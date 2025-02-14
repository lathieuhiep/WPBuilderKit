<?php
global $prefix_theme_options;

$column_width_fields = [
	[
		'id'      => 'sm',
		'type'    => 'slider',
		'title'   => esc_html__( 'sm: ≥576px', 'basictheme' ),
		'default' => 12,
		'min'     => 1,
		'max'     => 12,
	],

	[
		'id'      => 'md',
		'type'    => 'slider',
		'title'   => esc_html__( 'md: ≥768px', 'basictheme' ),
		'default' => 6,
		'min'     => 1,
		'max'     => 12,
	],

	[
		'id'      => 'lg',
		'type'    => 'slider',
		'title'   => esc_html__( 'lg: ≥992px', 'basictheme' ),
		'default' => 3,
		'min'     => 1,
		'max'     => 12,
	],

	[
		'id'      => 'xl',
		'type'    => 'slider',
		'title'   => esc_html__( 'lg: ≥1200px', 'basictheme' ),
		'default' => 3,
		'min'     => 1,
		'max'     => 12,
	],
];

//
// -> Create a section footer
CSF::createSection( $prefix_theme_options, array(
	'id'    => 'opt_footer_section',
	'icon'  => 'fas fa-stream',
	'title' => esc_html__( 'Chân trang', 'basictheme' ),
) );

// footer columns
CSF::createSection( $prefix_theme_options, array(
	'parent' => 'opt_footer_section',
	'title'  => esc_html__( 'Cài đặt cột sidebar', 'basictheme' ),
	'fields' => array(
		// select columns
		array(
			'id'      => 'opt_footer_columns',
			'type'    => 'select',
			'title'   => esc_html__( 'Number of footer columns', 'basictheme' ),
			'options' => array(
				'0' => esc_html__( 'Hide', 'basictheme' ),
				'1' => 1,
				'2' => 2,
				'3' => 3,
				'4' => 4,
			),
			'default' => '4'
		),

		// column width 1
		array(
			'id'         => 'opt_footer_column_width_1',
			'type'       => 'fieldset',
			'title'      => esc_html__( 'Độ rộng cột 1', 'basictheme' ),
			'fields'     => $column_width_fields,
			'dependency' => array( 'opt_footer_columns', '!=', '0' )
		),

		// column width 2
		array(
			'id'         => 'opt_footer_column_width_2',
			'type'       => 'fieldset',
			'title'      => esc_html__( 'Độ rộng cột 2', 'basictheme' ),
			'fields'     => $column_width_fields,
			'dependency' => array( 'opt_footer_columns', 'not-any', '0,1' )
		),

		// column width 3
		array(
			'id'         => 'opt_footer_column_width_3',
			'type'       => 'fieldset',
			'title'      => esc_html__( 'Độ rộng cột 3', 'basictheme' ),
			'fields'     => $column_width_fields,
			'dependency' => array( 'opt_footer_columns', 'not-any', '0,1,2' )
		),

		// column width 4
		array(
			'id'         => 'opt_footer_column_width_4',
			'type'       => 'fieldset',
			'title'      => esc_html__( 'Độ rộng cột 4', 'basictheme' ),
			'fields'     => $column_width_fields,
			'dependency' => array( 'opt_footer_columns', 'not-any', '0,1,2,3' )
		),
	)
) );

// Copyright
CSF::createSection( $prefix_theme_options, array(
	'parent' => 'opt_footer_section',
	'title'  => esc_html__( 'Copyright', 'basictheme' ),
	'fields' => array(
		// show
		array(
			'id'         => 'opt_footer_copyright_show',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Hiện thị copyright', 'basictheme' ),
			'text_on'    => esc_html__( 'Có', 'basictheme' ),
			'text_off'   => esc_html__( 'Không', 'basictheme' ),
			'text_width' => 80,
			'default'    => true
		),

		// content
		array(
			'id'            => 'opt_footer_copyright_content',
			'type'          => 'wp_editor',
			'title'         => esc_html__( 'Nội dung', 'basictheme' ),
			'media_buttons' => false,
			'default'       => esc_html__( 'Copyright &copy; DiepLK', 'basictheme' )
		),
	)
) );