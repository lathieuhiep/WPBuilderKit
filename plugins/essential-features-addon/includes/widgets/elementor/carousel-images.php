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

        // Add controls image size
		efa_add_image_size_control($this);

        // add control repeater
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
		efa_add_additional_options_section( $this, true );

        // Breakpoints options
		efa_add_breakpoints_controls_grouped( $this );
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
		$swiperOptions = efa_generate_slide_config( $settings );
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