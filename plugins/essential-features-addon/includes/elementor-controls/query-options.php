<?php

use Elementor\Controls_Manager;

// define default query options for Elementor widgets
function efa_default_query_options(): array {
	return [
		'taxonomy' => true,
		'limit'    => true,
		'order_by' => true,
		'order'    => true,
		'excerpt'  => true
	];
}

// filter query options based on excluded keys
function efa_filter_query_options( array $exclude_keys = [] ): array {
	$options = efa_default_query_options();

	foreach ( $exclude_keys as $key ) {
		if ( isset( $options[ $key ] ) ) {
			$options[ $key ] = false;
		}
	}

	return $options;
}

// Add options for Elementor widgets to select query parameters
function efa_add_query_controls( $widget, $section_id = null, $limit = 6, $taxonomy = 'category', $exclude_options = [], callable $after_controls = null ): void {
	$options = efa_filter_query_options( $exclude_options );

	// set section
	if ( ! $section_id ) {
		$section_id = 'content_section';
	}

	// show controls
	$widget->start_controls_section(
		$section_id,
		[
			'label' => esc_html__( 'Thiết lập bài viết', 'essential-features-addon' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		]
	);

	if ( $options['taxonomy'] && taxonomy_exists( $taxonomy ) ) {
		$widget->add_control(
			'taxonomy',
			[
				'label'       => esc_html__( 'Chọn danh mục', 'essential-features-addon' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => efa_check_get_cat( $taxonomy ),
				'multiple'    => true,
				'label_block' => true
			]
		);
	}

	if ( $options['limit'] ) {
		$widget->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Số bài lấy ra', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => $limit,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);
	}

	if ( $options['order_by'] ) {
		$widget->add_control(
			'order_by',
			[
				'label'   => esc_html__( 'Sắp xếp theo', 'essential-features-addon' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ID',
				'options' => [
					'ID'    => esc_html__( 'ID', 'essential-features-addon' ),
					'title' => esc_html__( 'Tiêu đề', 'essential-features-addon' ),
					'date'  => esc_html__( 'Ngày đăng', 'essential-features-addon' )
				],
			]
		);
	}

	if ( $options['order'] ) {
		$widget->add_control(
			'order',
			[
				'label'   => esc_html__( 'Sắp xếp', 'essential-features-addon' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC'  => esc_html__( 'Tăng dần', 'essential-features-addon' ),
					'DESC' => esc_html__( 'Giảm dần', 'essential-features-addon' ),
				],
			]
		);
	}

	if ( $options['excerpt'] ) {
		$widget->add_control(
			'show_excerpt',
			[
				'label'   => esc_html__( 'Hiện thị tóm tắt', 'essential-features-addon' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'show' => [
						'title' => esc_html__( 'Có', 'essential-features-addon' ),
						'icon'  => 'eicon-check',
					],
					'hide' => [
						'title' => esc_html__( 'Không', 'essential-features-addon' ),
						'icon'  => 'eicon-ban',
					],
				],
				'default' => 'show'
			]
		);

		$widget->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__( 'Số lượng từ hiển thị', 'essential-features-addon' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 12,
				'condition' => [
					'show_excerpt' => 'show',
				],
			]
		);
	}

	if ( is_callable( $after_controls ) ) {
		call_user_func( $after_controls, $widget );
	}

	$widget->end_controls_section();
}

function efa_build_post_query( $settings, $post_type = 'post', $taxonomy = 'category', $custom_args = [], $exclude_options = [] ): WP_Query {
	$options = efa_filter_query_options( $exclude_options );

	// default arguments for WP_Query
	$args = [
		'post_type'           => $post_type,
		'ignore_sticky_posts' => 1,
	];

	// add arguments posts_per_page
	if ( $options['limit'] && isset( $settings['limit'] ) ) {
		$args['posts_per_page'] = (int) $settings['limit'];
	}

	// add arguments for order_by and order
	if ( $options['order_by'] && isset( $settings['order_by'] ) ) {
		$args['orderby'] = $settings['order_by'];
	}
	if ( $options['order'] && isset( $settings['order'] ) ) {
		$args['order'] = $settings['order'];
	}

	// add arguments tax_query for taxonomy
	$selected_terms = $settings['taxonomy'];

	if ( $options['taxonomy'] && ! empty( $selected_terms ) && taxonomy_exists( $taxonomy ) ) {
		$args['tax_query'] = [
			[
				'taxonomy' => $taxonomy,
				'field'    => 'term_id',
				'terms'    => $selected_terms,
			],
		];
	}

	// merge custom arguments
	if ( ! empty( $custom_args ) ) {
		$args = array_merge( $args, $custom_args );
	}

	return new WP_Query( $args );
}
