<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;

// options slider global
function efa_add_additional_options_section( $widget, $include_equal_height = false ): void {
	$widget->start_controls_section(
		'content_additional_options',
		[
			'label' => esc_html__( 'Tùy chọn bổ sung', 'essential-features-addon' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		]
	);

	if ( $include_equal_height ) {
		$widget->add_control(
			'equal_height',
			[
				'label'        => esc_html__( 'Đồng bộ chiều cao slide', 'essential-features-addon' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Có', 'essential-features-addon' ),
				'label_off'    => esc_html__( 'Không', 'essential-features-addon' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
	}

	$widget->add_control(
		'loop',
		[
			'type'         => Controls_Manager::SWITCHER,
			'label'        => esc_html__( 'Vòng lặp', 'essential-features-addon' ),
			'label_on'     => esc_html__( 'Có', 'essential-features-addon' ),
			'label_off'    => esc_html__( 'Không', 'essential-features-addon' ),
			'return_value' => 'yes',
			'default'      => 'yes',
		]
	);

	$widget->add_control(
		'autoplay',
		[
			'label'        => esc_html__( 'Tự động chạy', 'essential-features-addon' ),
			'type'         => Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Có', 'essential-features-addon' ),
			'label_off'    => esc_html__( 'Không', 'essential-features-addon' ),
			'return_value' => 'yes',
			'default'      => '',
		]
	);

	$widget->add_control(
		'speed',
		[
			'label'   => esc_html__( 'Tốc độ trượt (ms)', 'essential-features-addon' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 800,
			'min'     => 100,
			'max'     => 5000,
			'step'    => 50,
		]
	);

	$widget->add_control(
		'navigation',
		[
			'label'   => esc_html__( 'Thanh điều hướng', 'essential-features-addon' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'arrows',
			'options' => [
				'both'   => esc_html__( 'Mũi tên và Dấu chấm', 'essential-features-addon' ),
				'arrows' => esc_html__( 'Mũi tên', 'essential-features-addon' ),
				'dots'   => esc_html__( 'Dấu chấm', 'essential-features-addon' ),
				'none'   => esc_html__( 'Không', 'essential-features-addon' ),
			],
		]
	);

	$widget->end_controls_section();
}

// Add Breakpoints Section
function efa_get_breakpoints(): array {
	return [
		[
			'prefix' => 'desktop_large',
			'label'  => esc_html__( 'Từ 1200px', 'essential-features-addon' ),
			'width'  => 1200,
			'items'  => 4,
			'space'  => 24,
		],
		[
			'prefix' => 'desktop_small',
			'label'  => esc_html__( 'Từ 992px', 'essential-features-addon' ),
			'width'  => 992,
			'items'  => 3,
			'space'  => 20,
		],
		[
			'prefix' => 'tablet_large',
			'label'  => esc_html__( 'Từ 768px', 'essential-features-addon' ),
			'width'  => 768,
			'items'  => 3,
			'space'  => 16,
		],
		[
			'prefix' => 'tablet_small',
			'label'  => esc_html__( 'Từ 576px', 'essential-features-addon' ),
			'width'  => 576,
			'items'  => 2,
			'space'  => 12,
		],
		[
			'prefix' => 'mobile_large',
			'label'  => esc_html__( 'Từ 480px', 'essential-features-addon' ),
			'width'  => 480,
			'items'  => 2,
			'space'  => 8,
		],
		[
			'prefix' => 'mobile',
			'label'  => esc_html__( 'Dưới 480px', 'essential-features-addon' ),
			'width'  => 0,
			'items'  => 1,
			'space'  => 4,
		],
	];
}

function efa_add_breakpoints_controls_grouped( $widget ): void {
	$widget->start_controls_section(
		'slider_breakpoints',
		[
			'label' => esc_html__( 'Tùy chọn Responsive', 'essential-features-addon' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		]
	);

	foreach ( efa_get_breakpoints() as $bp ) {
		$prefix = $bp['prefix'];

		$widget->add_control(
			"{$prefix}_options",
			[
				'label'     => $bp['label'],
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$widget->add_control(
			"{$prefix}_items",
			[
				'label'   => esc_html__( 'Hiển thị', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => $bp['items'],
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$widget->add_control(
			"{$prefix}_spaces_between",
			[
				'label'   => esc_html__( 'Khoảng cách', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => $bp['space'],
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
			]
		);
	}

	$widget->end_controls_section();
}

// generate config for slide
function efa_generate_slide_breakpoints( $settings, $breakpoints = null ): array {
	$breakpoints = ! empty( $breakpoints ) ? $breakpoints : efa_get_breakpoints();

	usort( $breakpoints, function( $a, $b ) {
		return $a['width'] <=> $b['width'];
	} );

	$result = [];

	foreach ( $breakpoints as $bp ) {
		$prefix = $bp['prefix'];
		$width  = $bp['width'];

		$result[ $width ] = [
			'slidesPerView' => intval( $settings[ "{$prefix}_items" ] ?? $bp['items'] ),
			'spaceBetween'  => intval( $settings[ "{$prefix}_spaces_between" ] ?? $bp['space'] ),
		];
	}

	return $result;
}

function efa_generate_slide_config( $settings, $use_breakpoints = true, $custom_breakpoints = [], $extra = [] ): string {
	$config = [
		'loop'       => ( 'yes' === ( $settings['loop'] ?? '' ) ),
		'autoplay'   => ( 'yes' === ( $settings['autoplay'] ?? '' ) ),
		'speed'      => intval( $settings['speed'] ?? 800 ),
		'navigation' => ( $settings['navigation'] === 'both' || $settings['navigation'] === 'arrows' ),
		'pagination' => ( $settings['navigation'] === 'both' || $settings['navigation'] === 'dots' ),
	];

	if ( isset( $settings['equal_height'] ) ) {
		$config['equalHeight'] = ( 'yes' === $settings['equal_height'] );
	}

	if ( $use_breakpoints ) {
		$config['breakpoints'] = efa_generate_slide_breakpoints( $settings, $custom_breakpoints );
	}

	// merge with extra config
	if ( ! empty( $extra ) ) {
		$config = array_merge( $config, $extra );
	}

	return wp_json_encode( $config );
}