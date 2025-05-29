<?php

use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EFA_Widget_Carousel_Images extends Widget_Base {

	// widget name
	public function get_name(): string {
		return 'efa-carousel-images';
	}

	// widget title
	public function get_title(): string {
		return esc_html__( 'Ảnh trình chiếu', 'essential-features-addon' );
	}

	// widget icon
	public function get_icon(): string {
		return 'eicon-slider-full-screen';
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
		return ['carousel', 'image', 'slider'];
	}

	// widget controls
	protected function register_controls(): void {

		// Section carousel images
		$this->start_controls_section(
			'section_carousel_images',
			[
				'label' => esc_html__( 'Trình chiếu ảnh', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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

		$repeater = new Repeater();

		$repeater->add_control(
			'list_title', [
				'label'       => esc_html__( 'Tên', 'essential-features-addon' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Tên #1', 'essential-features-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_image',
			[
				'label'   => esc_html__( 'Chọn ảnh', 'essential-features-addon' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'list_link',
			[
				'label'       => esc_html__( 'URL', 'essential-features-addon' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'essential-features-addon' ),
				'default'     => [
					'url'               => '',
					'is_external'       => true,
					'nofollow'          => true,
					'custom_attributes' => '',
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label'       => esc_html__( 'Danh sách', 'essential-features-addon' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'list_title' => __( 'Tên #1', 'essential-features-addon' ),
					],
					[
						'list_title' => __( 'Tên #2', 'essential-features-addon' ),
					],
					[
						'list_title' => __( 'Tên #3', 'essential-features-addon' ),
					],
					[
						'list_title' => __( 'Tên #4', 'essential-features-addon' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
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
	}

	// widget output on the frontend
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		// Add classes for the slider wrapper
		$classes = ['efa-addon-carousel-images swiper efa-custom-swiper-slider'];

		if ( $settings['equal_height'] === 'yes' ) {
			$classes[] = 'efa-equal-height';
		}

		$this->add_render_attribute( 'classes', 'class', $classes );

        // set settings for swiper
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
		?>

        <div <?php echo $this->get_render_attribute_string( 'classes' ); ?> data-settings-swiper='<?php echo esc_attr( $swiperOptions ); ?>'>
            <div class="swiper-wrapper">
				<?php
				foreach ( $settings['list'] as $index => $item ) :
					$image_id = $item['list_image']['id'];
					$url = $item['list_link']['url'];
					?>

                    <div class="item swiper-slide elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
						<?php
                        if ( $image_id ) :
	                        echo wp_get_attachment_image( $image_id, $settings['image_size'] );
                        else:
                        ?>
                            <img src="<?php echo esc_url( EFA_PLUGIN_URL . 'assets/images/no-image.png' ); ?>" alt="<?php the_title(); ?>"/>
                        <?php
                        endif;

						if ( $url ) :
							$link_key = 'link_' . $index;
							$this->add_link_attributes( $link_key, $item['list_link'] );
                        ?>

                            <a class="item__link" <?php echo $this->get_render_attribute_string( $link_key ); ?>></a>

						<?php endif; ?>
                    </div>

				<?php endforeach; ?>
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
	}
}