<?php

use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EFB_Widget_Carousel_Images extends Widget_Base {

	// widget name
	public function get_name(): string {
		return 'efb-carousel-images';
	}

	// widget title
	public function get_title(): string {
		return esc_html__( 'Carousel Images', 'essentials-for-basic' );
	}

	// widget icon
	public function get_icon(): string {
		return 'eicon-slider-album';
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

		// Section carousel images
		$this->start_controls_section(
			'section_carousel_images',
			[
				'label' => __( 'Carousel Images', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'list_title', [
				'label'       => esc_html__( 'Name', 'essentials-for-basic' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Title #1', 'essentials-for-basic' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_image',
			[
				'label'   => esc_html__( 'Choose Image', 'essentials-for-basic' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'list_link',
			[
				'label'       => esc_html__( 'Link', 'essentials-for-basic' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'essentials-for-basic' ),
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
				'label'       => esc_html__( 'List', 'essentials-for-basic' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'list_title' => __( 'Title #1', 'essentials-for-basic' ),
					],
					[
						'list_title' => __( 'Title #2', 'essentials-for-basic' ),
					],
					[
						'list_title' => __( 'Title #3', 'essentials-for-basic' ),
					],
					[
						'list_title' => __( 'Title #4', 'essentials-for-basic' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();

		// Content additional options
		$this->start_controls_section(
			'content_additional_options',
			[
				'label' => esc_html__( 'Additional Options', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'loop',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Loop Slider ?', 'essentials-for-basic' ),
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
				'default' => 20,
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
				'default' => 4,
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

		// Section style
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'      => esc_html__( 'Dots Color', 'essentials-for-basic' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .element-carousel-images .owl-carousel .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'dots',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_color_hover',
			[
				'label'      => esc_html__( 'Dots Color Hover', 'essentials-for-basic' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .element-carousel-images .owl-carousel .owl-dots .owl-dot.active span, {{WRAPPER}} .element-carousel-images .owl-carousel .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'dots',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->end_controls_section();

	}

	// widget output on the frontend
	protected function render(): void {
		$settings = $this->get_settings_for_display();

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
		?>

        <div class="element-carousel-images">
            <div class="custom-owl-carousel owl-carousel owl-theme"
                 data-settings-owl='<?php echo wp_json_encode( $data_settings_owl ); ?>'>
				<?php
				foreach ( $settings['list'] as $index => $item ) :
					$image_id = $item['list_image']['id'];
					$url = $item['list_link']['url'];

					?>

                    <div class="item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
						<?php
						echo wp_get_attachment_image( $image_id, 'full' );

						if ( $url ) :
							$link_key = 'link_' . $index;
							$this->add_link_attributes( $link_key, $item['list_link'] );
							?>

                            <a class="item__link" <?php echo $this->get_render_attribute_string( $link_key ); ?>></a>

						<?php endif; ?>
                    </div>

				<?php endforeach; ?>
            </div>
        </div>

		<?php
	}
}