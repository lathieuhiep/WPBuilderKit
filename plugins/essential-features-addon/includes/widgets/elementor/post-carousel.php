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
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Thiết lập bài viết', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'select_cat',
			[
				'label'       => esc_html__( 'Chọn danh mục', 'essential-features-addon' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => efa_check_get_cat( 'category' ),
				'multiple'    => true,
				'label_block' => true
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Số bài lấy ra', 'essential-features-addon' ),
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
				'label'   => esc_html__( 'Sắp xếp theo', 'essential-features-addon' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ID',
				'options' => [
					'ID'    => esc_html__( 'ID', 'essential-features-addon' ),
					'title' => esc_html__( 'Tiêu đề', 'essential-features-addon' ),
					'date'  => esc_html__( 'Ngày đăng', 'essential-features-addon' ),
					'rand'  => esc_html__( 'Ngẫu nhiên', 'essential-features-addon' ),
				],
			]
		);

		$this->add_control(
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

		$this->add_control(
			'show_excerpt',
			[
				'label'   => esc_html__( 'Hiên thị tóm tắt', 'essential-features-addon' ),
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

		$this->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__( 'Số lượng từ hiển thị', 'essential-features-addon' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '10',
				'condition' => [
					'show_excerpt' => 'show',
				],
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Độ phân giải ảnh', 'lpbcolor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'large',
				'options' => efa_image_size_options(),
				'label_block' => true
			]
		);

		$this->end_controls_section();

		// additional options
		$this->start_controls_section(
			'content_additional_options',
			[
				'label' => esc_html__( 'Tùy chọn bổ sung', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'equal_height',
			[
				'label' => esc_html__( 'Đồng bộ chiều cao slide', 'essential-features-addon' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Có', 'essential-features-addon' ),
				'label_off' => esc_html__( 'Không', 'essential-features-addon' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
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

		$this->add_control(
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

		$this->add_control(
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

		$this->add_control(
			'navigation',
			[
				'label' => esc_html__( 'Thanh điều hướng', 'essential-features-addon' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'  => esc_html__( 'Mũi tên và Dấu chấm', 'essential-features-addon' ),
					'arrows'  => esc_html__( 'Mũi tên', 'essential-features-addon' ),
					'dots'  => esc_html__( 'Dấu chấm', 'essential-features-addon' ),
					'none' => esc_html__( 'Không', 'essential-features-addon' ),
				],
			]
		);

		$this->end_controls_section();

		// Breakpoints options
		efa_add_all_breakpoints_sections( $this );

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
		$settings      = $this->get_settings_for_display();

        // Add classes for the slider wrapper
		$classes = ['efa-addon-post-carousel swiper efa-custom-swiper-slider'];

		if ( $settings['equal_height'] === 'yes' ) {
			$classes[] = 'efa-equal-height';
		}

		$this->add_render_attribute( 'classes', 'class', $classes );

        // query settings
		$cat_post      = $settings['select_cat'];
		$limit_post    = $settings['limit'];
		$order_by_post = $settings['order_by'];
		$order_post    = $settings['order'];

		$data_settings_swiper = [
			'loop'       => ( 'yes' === $settings['loop'] ),
			'autoplay'   => ( 'yes' === $settings['autoplay'] ),
			'speed'      => intval( $settings['speed'] ),
			'navigation' => ( $settings['navigation'] == 'both' || $settings['navigation'] == 'arrows' ),
			'pagination' => ( $settings['navigation'] == 'both' || $settings['navigation'] == 'dots' ),
			'breakpoints' => [
				0    => [
					'slidesPerView' => intval( $settings['mobile_items'] ),
					'spaceBetween'  => intval( $settings['mobile_spaces_between'] )
				],
				480  => [
					'slidesPerView' => intval( $settings['mobile_large_items'] ),
					'spaceBetween'  => intval( $settings['mobile_large_spaces_between'] )
				],
				576  => [
					'slidesPerView' => intval( $settings['tablet_small_items'] ),
					'spaceBetween'  => intval( $settings['tablet_small_spaces_between'] )
				],
				768  => [
					'slidesPerView' => intval( $settings['tablet_large_items'] ),
					'spaceBetween'  => intval( $settings['tablet_large_spaces_between'] )
				],
				992  => [
					'slidesPerView' => intval( $settings['desktop_small_items'] ),
					'spaceBetween'  => intval( $settings['desktop_small_spaces_between'] )
				],
				1200 => [
					'slidesPerView' => intval( $settings['desktop_large_items'] ),
					'spaceBetween'  => intval( $settings['desktop_large_spaces_between'] )
				]
			]
		];
		$swiperOptions = wp_json_encode( $data_settings_swiper );

		// Query
		$args = array(
			'post_type'           => 'post',
			'posts_per_page'      => $limit_post,
			'orderby'             => $order_by_post,
			'order'               => $order_post,
			'ignore_sticky_posts' => 1,
		);

		if ( ! empty( $cat_post ) && is_array( $cat_post ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $cat_post,
				),
			);
		}

		$query = new WP_Query( $args );

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