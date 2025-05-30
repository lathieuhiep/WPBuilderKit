<?php

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EFA_Widget_Post_Carousel extends Widget_Base {

	// widget name
	public function get_name(): string {
		return 'efa-post-carousel';
	}

	// widget title
	public function get_title(): string {
		return esc_html__( 'Slider bài viết', 'essential-features-addon' );
	}

	// widget icon
	public function get_icon(): string {
		return 'eicon-slider-push';
	}

	// widget categories
	public function get_categories(): array {
		return array( 'efa-addons' );
	}

	// widget style dependencies
	public function get_style_depends(): array {
		return [ 'swiper' ];
	}

	// widget scripts dependencies
	public function get_script_depends(): array {
		return [ 'swiper', 'efa-elementor-script' ];
	}

	// widget keywords
	public function get_keywords(): array
	{
		return ['carousel', 'post', 'slider'];
	}

	// widget controls
	protected function register_controls(): void {

		// Content section
		efa_add_query_controls( $this, '', 6, 'category', [], function ($widget) {
			efa_add_image_size_control( $widget );
        } );

		// additional options
		efa_add_additional_options_section( $this, true );;

		// Breakpoints options
		efa_add_breakpoints_controls_grouped( $this );

		// Style title
		$this->start_controls_section(
			'style_title',
			[
				'label' => esc_html__( 'Tiêu đề', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Màu', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .item .title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => esc_html__( 'Màu khi di chuột', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .item .title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .item .title',
			]
		);

		$this->add_responsive_control(
			'title_align',
			[
				'label'     => esc_html__( 'Căn chỉnh', 'essential-features-addon' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => esc_html__( 'Trái', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-left',
					],

					'center' => [
						'title' => esc_html__( 'Giữa', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-center',
					],

					'right' => [
						'title' => esc_html__( 'Phải', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-right',
					],

					'justify' => [
						'title' => esc_html__( 'Căn đều hai lề', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .item .title' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		// Style excerpt
		$this->start_controls_section(
			'style_excerpt',
			[
				'label'     => esc_html__( 'Nôi dung tóm tắt', 'essential-features-addon' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'show',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => esc_html__( 'Màu', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .item .desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .item .desc',
			]
		);

		$this->add_responsive_control(
			'excerpt_align',
			[
				'label'     => esc_html__( 'Căn chỉnh', 'essential-features-addon' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => esc_html__( 'Trái', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-left',
					],

					'center' => [
						'title' => esc_html__( 'Giữa', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-center',
					],

					'right' => [
						'title' => esc_html__( 'Phải', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-right',
					],

					'justify' => [
						'title' => esc_html__( 'Căn đều hai lề', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .item .desc' => 'text-align: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

	}

	// widget output on the frontend
	protected function render(): void {
		$settings = $this->get_settings_for_display();

        // Add classes for the slider wrapper
		$classes = ['efa-addon-post-carousel swiper efa-custom-swiper-slider'];

		if ( $settings['equal_height'] === 'yes' ) {
			$classes[] = 'efa-equal-height';
		}

		$this->add_render_attribute( 'classes', 'class', $classes );

		// set settings for swiper
		$swiperOptions = efa_generate_slide_config( $settings );

        // query settings
		$query = efa_build_post_query( $settings );

		if ( $query->have_posts() ) :
        ?>
            <div <?php echo $this->get_render_attribute_string( 'classes' ); ?> data-settings-swiper='<?php echo esc_attr( $swiperOptions ); ?>'>
                <div class="swiper-wrapper">
					<?php while ( $query->have_posts() ): $query->the_post(); ?>
                        <div class="item swiper-slide">
                            <div class="thumbnail">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
									<?php
									if ( has_post_thumbnail() ) :
										the_post_thumbnail( $settings['image_size'] );
									else:
                                    ?>
                                        <img src="<?php echo esc_url( EFA_PLUGIN_URL . 'assets/images/no-image.png' ); ?>" alt="<?php the_title(); ?>"/>
									<?php endif; ?>
                                </a>
                            </div>

                            <div class="body">
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
					<?php endwhile; wp_reset_postdata(); ?>
                </div>

	            <?php if ( $settings['navigation'] == 'both' || $settings['navigation'] == 'dots' ) : ?>
                    <div class="swiper-pagination"></div>
	            <?php endif; ?>

	            <?php if ( $settings['navigation'] == 'both' || $settings['navigation'] == 'arrows' ) : ?>
                    <div class="swiper-button-prev">
                        <i class="efa-icon-mask efa-icon-mask-angle-left"></i>
                    </div>

                    <div class="swiper-button-next">
                        <i class="efa-icon-mask efa-icon-mask-angle-right"></i>
                    </div>
	            <?php endif; ?>
            </div>
		<?php
		endif;
	}
}