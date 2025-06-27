<?php
//
// -> Create a section footer
CSF::createSection( PREFIX_THEME_OPTIONS, array(
	'id'    => 'opt_footer_section',
	'icon'  => 'fas fa-stream',
	'title' => esc_html__( 'Chân trang', 'basictheme' ),
) );

// footer columns
CSF::createSection( PREFIX_THEME_OPTIONS, array(
	'parent' => 'opt_footer_section',
	'title'  => esc_html__( 'Cài đặt cột sidebar', 'basictheme' ),
	'fields' => array(
		// select columns
		array(
			'id'      => 'opt_footer_columns',
			'type'    => 'select',
			'title'   => esc_html__( 'Số lượng cột hiển thị', 'basictheme' ),
			'options' => array(
				'0' => esc_html__( 'Ẩn', 'basictheme' ),
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
			'fields'     => basictheme_column_width_fields(),
			'dependency' => array( 'opt_footer_columns', '!=', '0' )
		),

		// column width 2
		array(
			'id'         => 'opt_footer_column_width_2',
			'type'       => 'fieldset',
			'title'      => esc_html__( 'Độ rộng cột 2', 'basictheme' ),
			'fields'     => basictheme_column_width_fields(),
			'dependency' => array( 'opt_footer_columns', 'not-any', '0,1' )
		),

		// column width 3
		array(
			'id'         => 'opt_footer_column_width_3',
			'type'       => 'fieldset',
			'title'      => esc_html__( 'Độ rộng cột 3', 'basictheme' ),
			'fields'     => basictheme_column_width_fields(),
			'dependency' => array( 'opt_footer_columns', 'not-any', '0,1,2' )
		),

		// column width 4
		array(
			'id'         => 'opt_footer_column_width_4',
			'type'       => 'fieldset',
			'title'      => esc_html__( 'Độ rộng cột 4', 'basictheme' ),
			'fields'     => basictheme_column_width_fields(),
			'dependency' => array( 'opt_footer_columns', 'not-any', '0,1,2,3' )
		),
	)
) );

// Copyright
CSF::createSection( PREFIX_THEME_OPTIONS, array(
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