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
		return [ 'owl.carousel' ];
	}

	// widget scripts dependencies
	public function get_script_depends(): array {
		return [ 'owl.carousel', 'efa-elementor-script' ];
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
				'default' => 'id',
				'options' => [
					'id'    => esc_html__( 'ID', 'essential-features-addon' ),
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

		// mobile options
		$this->start_controls_section(
			'mobile_options',
			[
				'label' => esc_html__( 'Dưới 480px', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'mobile_items',
			[
				'label'   => esc_html__( 'Hiển thị', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'mobile_spaces_between',
			[
				'label'   => esc_html__( 'Khoảng cách', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->end_controls_section();

		// mobile large options
		$this->start_controls_section(
			'mobile_large_options',
			[
				'label' => esc_html__( 'Từ 480px', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'mobile_large_items',
			[
				'label'   => esc_html__( 'Hiển thị', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'mobile_large_spaces_between',
			[
				'label'   => esc_html__( 'Khoảng cách', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->end_controls_section();

		// tablet small options
		$this->start_controls_section(
			'tablet_small_options',
			[
				'label' => esc_html__( 'Từ 576px', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'tablet_small_items',
			[
				'label'   => esc_html__( 'Hiển thị', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'tablet_small_spaces_between',
			[
				'label'   => esc_html__( 'Khoảng cách', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 12,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->end_controls_section();

		// tablet large options
		$this->start_controls_section(
			'tablet_large_options',
			[
				'label' => esc_html__( 'Từ 768px', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'tablet_large_items',
			[
				'label'   => esc_html__( 'Hiển thị', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'tablet_large_spaces_between',
			[
				'label'   => esc_html__( 'Khoảng cách', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 16,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->end_controls_section();

		// desktop small options
		$this->start_controls_section(
			'desktop_small_options',
			[
				'label' => esc_html__( 'Từ 992px', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'desktop_small_items',
			[
				'label'   => esc_html__( 'Hiển thị', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'desktop_small_spaces_between',
			[
				'label'   => esc_html__( 'Khoảng cách', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 20,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->end_controls_section();

		// desktop large options
		$this->start_controls_section(
			'desktop_large_options',
			[
				'label' => esc_html__( 'Từ 1200px', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'desktop_large_items',
			[
				'label'   => esc_html__( 'Hiển thị', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
			]
		);

		$this->add_control(
			'desktop_large_spaces_between',
			[
				'label'   => esc_html__( 'Khoảng cách', 'essential-features-addon' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 24,
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
					'{{WRAPPER}} .element-post-carousel .item-post__content .title a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .element-post-carousel .item-post__content .title' => 'text-align: {{VALUE}};',
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
					'{{WRAPPER}} .element-post-carousel .item-post__content .desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .element-post-carousel .item-post__content .desc',
			]
		);

		$this->add_control(
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
					'{{WRAPPER}} .element-post-carousel .item-post__content .desc' => 'text-align: {{VALUE}};',
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
			'nav'        => $settings['navigation'] == 'both' || $settings['navigation'] == 'arrows',
			'dots'       => $settings['navigation'] == 'both' || $settings['navigation'] == 'dots',
			'autoplay'   => ( 'yes' === $settings['autoplay'] ),
			'responsive' => [
				'0' => array(
					'items'  => $settings['mobile_items'],
					'margin' => $settings['mobile_spaces_between']
				),

				'480' => array(
					'items'  => $settings['mobile_large_items'],
					'margin' => $settings['mobile_large_spaces_between']
				),

				'576' => array(
					'items'  => $settings['tablet_small_items'],
					'margin' => $settings['tablet_small_spaces_between']
				),

				'768' => array(
					'items' => $settings['tablet_large_items'],
					'margin' => $settings['tablet_large_spaces_between']
				),

				'992' => array(
					'items' => $settings['desktop_small_items'],
					'margin' => $settings['desktop_small_spaces_between']
				),

				'1200' => array(
					'items' => $settings['desktop_large_items'],
					'margin' => $settings['desktop_large_spaces_between']
				),
			]
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
            <div class="efa-addon-post-carousel">
                <div class="custom-owl-carousel owl-carousel owl-theme"
                     data-settings-owl='<?php echo wp_json_encode( $data_settings_owl ); ?>'>
					<?php while ( $query->have_posts() ): $query->the_post(); ?>

                        <div class="item">
                            <div class="thumbnail">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
									<?php
									if ( has_post_thumbnail() ) :
										the_post_thumbnail( $settings['image_size'] );
									else:
										?>
                                        <img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/no-image.png' ) ) ?>"
                                             alt="<?php the_title(); ?>"/>
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

					<?php endwhile;
					wp_reset_postdata(); ?>
                </div>
            </div>
		<?php
		endif;
	}
}