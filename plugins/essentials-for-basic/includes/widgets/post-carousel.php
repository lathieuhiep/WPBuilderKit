<?php

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EFB_Widget_Post_Carousel extends Widget_Base {

	// widget name
	public function get_name(): string {
		return 'efb-post-carousel';
	}

	// widget title
	public function get_title(): string {
		return esc_html__( 'Posts Carousel', 'essentials-for-basic' );
	}

	// widget icon
	public function get_icon(): string {
		return 'eicon-slider-push';
	}

	// widget categories
	public function get_categories(): array {
		return array( 'efb-addons' );
	}

	// widget style dependencies
	public function get_style_depends(): array {
		return [ 'owl.carousel' ];
	}

	// widget scripts dependencies
	public function get_script_depends(): array {
		return [ 'owl.carousel', 'efb-script' ];
	}

	// widget controls
	protected function register_controls(): void {

		// Content section
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Query', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'select_cat',
			[
				'label'       => esc_html__( 'Select Category', 'essentials-for-basic' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => efb_check_get_cat( 'category' ),
				'multiple'    => true,
				'label_block' => true
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Number of Posts', 'essentials-for-basic' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'order_by',
			[
				'label'   => esc_html__( 'Order By', 'essentials-for-basic' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'id',
				'options' => [
					'id'    => esc_html__( 'ID', 'essentials-for-basic' ),
					'title' => esc_html__( 'Title', 'essentials-for-basic' ),
					'date'  => esc_html__( 'Date', 'essentials-for-basic' ),
					'rand'  => esc_html__( 'Random', 'essentials-for-basic' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'essentials-for-basic' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC'  => esc_html__( 'Ascending', 'essentials-for-basic' ),
					'DESC' => esc_html__( 'Descending', 'essentials-for-basic' ),
				],
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'   => esc_html__( 'Show excerpt', 'essentials-for-basic' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'show' => [
						'title' => esc_html__( 'Yes', 'essentials-for-basic' ),
						'icon'  => 'eicon-check',
					],

					'hide' => [
						'title' => esc_html__( 'No', 'essentials-for-basic' ),
						'icon'  => 'eicon-ban',
					],
				],
				'default' => 'show'
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Words', 'essentials-for-basic' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '10',
				'condition' => [
					'show_excerpt' => 'show',
				],
			]
		);

		$this->end_controls_section();

		// Content additional options
		$this->start_controls_section(
			'additional_options_section',
			[
				'label' => esc_html__( 'Additional Options', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'loop',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Loop Slider?', 'essentials-for-basic' ),
				'label_off'    => esc_html__( 'No', 'essentials-for-basic' ),
				'label_on'     => esc_html__( 'Yes', 'essentials-for-basic' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Autoplay?', 'essentials-for-basic' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => esc_html__( 'No', 'essentials-for-basic' ),
				'label_on'     => esc_html__( 'Yes', 'essentials-for-basic' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'nav',
			[
				'label'        => esc_html__( 'Nav Slider', 'essentials-for-basic' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'essentials-for-basic' ),
				'label_off'    => esc_html__( 'No', 'essentials-for-basic' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'dots',
			[
				'label'        => esc_html__( 'Dots Slider', 'essentials-for-basic' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'essentials-for-basic' ),
				'label_off'    => esc_html__( 'No', 'essentials-for-basic' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'margin_item',
			[
				'label'   => esc_html__( 'Space Between Item', 'essentials-for-basic' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 30,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'min_width_1200',
			[
				'label'     => esc_html__( 'Min Width 1200px', 'essentials-for-basic' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'item',
			[
				'label'   => esc_html__( 'Number of Item', 'essentials-for-basic' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'min_width_992',
			[
				'label'     => esc_html__( 'Min Width 992px', 'essentials-for-basic' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'item_992',
			[
				'label'   => esc_html__( 'Number of Item', 'essentials-for-basic' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'min_width_768',
			[
				'label'     => esc_html__( 'Min Width 768px', 'essentials-for-basic' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'item_768',
			[
				'label'   => esc_html__( 'Number of Item', 'essentials-for-basic' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'min_width_568',
			[
				'label'     => esc_html__( 'Min Width 568px', 'essentials-for-basic' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'item_568',
			[
				'label'   => esc_html__( 'Number of Item', 'essentials-for-basic' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'margin_item_568',
			[
				'label'   => esc_html__( 'Space Between Item', 'essentials-for-basic' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 15,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'max_width_567',
			[
				'label'     => esc_html__( 'Max Width 567px', 'essentials-for-basic' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'item_567',
			[
				'label'   => esc_html__( 'Number of Item', 'essentials-for-basic' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'margin_item_567',
			[
				'label'   => esc_html__( 'Space Between Item', 'essentials-for-basic' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->end_controls_section();

		// Style title
		$this->start_controls_section(
			'style_title',
			[
				'label' => esc_html__( 'Title', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'essentials-for-basic' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .element-post-carousel .item-post__content .title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => esc_html__( 'Color Hover', 'essentials-for-basic' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .element-post-carousel .item-post__content .title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .element-post-carousel .item-post__content .title',
			]
		);

		$this->add_control(
			'title_alignment',
			[
				'label'     => esc_html__( 'Title Alignment', 'essentials-for-basic' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => esc_html__( 'Left', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-left',
					],

					'center' => [
						'title' => esc_html__( 'Center', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-center',
					],

					'right' => [
						'title' => esc_html__( 'Right', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-right',
					],

					'justify' => [
						'title' => esc_html__( 'Justified', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .element-post-carousel .item-post__content .title' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		// Style excerpt
		$this->start_controls_section(
			'style_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'essentials-for-basic' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'show',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__( 'Color', 'essentials-for-basic' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .element-post-carousel .item-post__content .desc p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .element-post-carousel .item-post__content .desc p',
			]
		);

		$this->add_control(
			'excerpt_alignment',
			[
				'label'     => esc_html__( 'Excerpt Alignment', 'essentials-for-basic' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => esc_html__( 'Left', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-left',
					],

					'center' => [
						'title' => esc_html__( 'Center', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-center',
					],

					'right' => [
						'title' => esc_html__( 'Right', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-right',
					],

					'justify' => [
						'title' => esc_html__( 'Justified', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .element-post-carousel .item-post__content .desc p' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

	}

	// widget output on the frontend
	protected function render(): void {
		$settings      = $this->get_settings_for_display();
		$cat_post      = $settings['select_cat'];
		$limit_post    = $settings['limit'];
		$order_by_post = $settings['order_by'];
		$order_post    = $settings['order'];

		$data_settings_owl = [
			'loop'       => ( 'yes' === $settings['loop'] ),
			'nav'        => ( 'yes' === $settings['nav'] ),
			'dots'       => ( 'yes' === $settings['dots'] ),
			'margin'     => $settings['margin_item'],
			'autoplay'   => ( 'yes' === $settings['autoplay'] ),
			'responsive' => [
				'0' => array(
					'items'  => $settings['item_567'],
					'margin' => $settings['margin_item_567']
				),

				'576' => array(
					'items'  => $settings['item_568'],
					'margin' => $settings['margin_item_568']
				),

				'768' => array(
					'items' => $settings['item_768']
				),

				'992' => array(
					'items' => $settings['item_992']
				),

				'1200' => array(
					'items' => $settings['item']
				),
			],
		];

		// Query
		$args = array(
			'post_type'           => 'post',
			'posts_per_page'      => $limit_post,
			'orderby'             => $order_by_post,
			'order'               => $order_post,
			'cat'                 => $cat_post,
			'ignore_sticky_posts' => 1,
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :

			?>
            <div class="element-post-carousel">
                <div class="custom-owl-carousel owl-carousel owl-theme"
                     data-settings-owl='<?php echo wp_json_encode( $data_settings_owl ); ?>'>
					<?php while ( $query->have_posts() ): $query->the_post(); ?>

                        <div class="item-post">
                            <div class="item-post__thumbnail">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
									<?php
									if ( has_post_thumbnail() ) :
										the_post_thumbnail( 'large' );
									else:
										?>
                                        <img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/no-image.png' ) ) ?>"
                                             alt="<?php the_title(); ?>"/>
									<?php endif; ?>
                                </a>
                            </div>

                            <div class="item-post__content">
                                <h2 class="title">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
										<?php the_title(); ?>
                                    </a>
                                </h2>

								<?php if ( $settings['show_excerpt'] == 'show' ) : ?>

                                    <div class="desc">
                                        <p>
											<?php
											if ( has_excerpt() ) :
												echo esc_html( wp_trim_words( get_the_excerpt(), $settings['excerpt_length'], '...' ) );
											else:
												echo esc_html( wp_trim_words( get_the_content(), $settings['excerpt_length'], '...' ) );
											endif;
											?>
                                        </p>
                                    </div>

								<?php endif; ?>
                            </div>
                        </div>

					<?php endwhile;
					wp_reset_postdata(); ?>
                </div>
            </div>
		<?php

		endif;
	}
}