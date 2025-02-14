<?php

use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EFA_Widget_Slides extends Widget_Base {

	// widget name
	public function get_name(): string {
		return 'efa-slides';
	}

	// widget title
	public function get_title(): string {
		return esc_html__( 'Slides Theme', 'essential-features-addon' );
	}

	// widget icon
	public function get_icon(): string {
		return 'eicon-slides';
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

	// widget controls
	protected function register_controls(): void {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Slides', 'essential-features-addon' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );

		$repeater->start_controls_tab( 'background', [ 'label' => esc_html__( 'Background', 'essential-features-addon' ) ] );

		$repeater->add_control(
			'slides_image',
			[
				'label'     => esc_html__( 'Image', 'essential-features-addon' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--bg' => 'background-image: url({{URL}})',
				],
			]
		);

		$repeater->add_control(
			'background_size',
			[
				'label'      => esc_html__( 'Size', 'essential-features-addon' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'cover',
				'options'    => [
					'cover'   => esc_html__( 'Cover', 'essential-features-addon' ),
					'contain' => esc_html__( 'Contain', 'essential-features-addon' ),
					'auto'    => esc_html__( 'Auto', 'essential-features-addon' ),
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--bg' => 'background-size: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'slides_image[url]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'background_overlay',
			[
				'label'      => esc_html__( 'Background Overlay', 'essential-features-addon' ),
				'type'       => Controls_Manager::SWITCHER,
				'default'    => '',
				'separator'  => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'     => 'slides_image[url]',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'background_overlay_color',
			[
				'label'      => esc_html__( 'Color', 'essential-features-addon' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => 'rgba(0,0,0,0.5)',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'background_overlay',
							'value' => 'yes',
						],
					],
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--inner .element-slides__item--overlay' => 'background-color: {{VALUE}}',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'content', [ 'label' => esc_html__( 'Content', 'essential-features-addon' ) ] );

		$repeater->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Title & Description', 'essential-features-addon' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Slide Heading', 'essential-features-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'      => esc_html__( 'Description', 'essential-features-addon' ),
				'type'       => Controls_Manager::TEXTAREA,
				'default'    => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'essential-features-addon' ),
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'essential-features-addon' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Click Here', 'essential-features-addon' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'essential-features-addon' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'default'     => [
					'is_external' => 'true',
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'essential-features-addon' ),
			]
		);

		$repeater->add_control(
			'show_content',
			[
				'label'        => esc_html__( 'Show Content', 'essential-features-addon' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'essential-features-addon' ),
				'label_off'    => esc_html__( 'Hide', 'essential-features-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => esc_html__( 'Style', 'essential-features-addon' ) ] );

		$repeater->add_control(
			'custom_style',
			[
				'label'       => esc_html__( 'Custom', 'essential-features-addon' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Set custom style that will only affect this specific slide.', 'essential-features-addon' ),
			]
		);

		$repeater->add_control(
			'horizontal_position',
			[
				'label'                => esc_html__( 'Horizontal Position', 'essential-features-addon' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'essential-features-addon' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'essential-features-addon' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'essential-features-addon' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors'            => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--inner .element-slides__item--content' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right'  => 'margin-left: auto',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'vertical_position',
			[
				'label'                => esc_html__( 'Vertical Position', 'essential-features-addon' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => esc_html__( 'Top', 'essential-features-addon' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'essential-features-addon' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'essential-features-addon' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors'            => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--inner' => 'align-items: {{VALUE}}; -webkit-align-items: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'conditions'           => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'text_align',
			[
				'label'       => esc_html__( 'Text Align', 'essential-features-addon' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .element-slides__item--inner' => 'text-align: {{VALUE}}',
				],
				'conditions'  => [
					'terms' => [
						[
							'name'  => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides_list',
			[
				'label'       => esc_html__( 'Slides', 'essential-features-addon' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'heading'     => esc_html__( 'Slider 1 Heading', 'essential-features-addon' ),
						'description' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'essential-features-addon' ),
						'button_text' => esc_html__( 'Click Here', 'essential-features-addon' ),
						'link'        => '#'
					],
					[
						'heading'     => esc_html__( 'Slider 2 Heading', 'essential-features-addon' ),
						'description' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'essential-features-addon' ),
						'button_text' => esc_html__( 'Click Here', 'essential-features-addon' ),
						'link'        => '#'
					],
				],
				'title_field' => '{{{ heading }}}',
			]
		);

		$this->add_responsive_control(
			'slides_height',
			[
				'label'      => esc_html__( 'Height', 'essential-features-addon' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 400,
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .element-slides__item' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'essential-features-addon' ),
				'tab'   => Controls_Manager::SECTION
			]
		);

		$this->add_control(
			'loop',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => esc_html__( 'Vòng lặp', 'essential-features-addon' ),
				'label_off'    => esc_html__( 'Không', 'essential-features-addon' ),
				'label_on'     => esc_html__( 'Có', 'essential-features-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Tự động chạy', 'essential-features-addon' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => esc_html__( 'Không', 'essential-features-addon' ),
				'label_on'     => esc_html__( 'Có', 'essential-features-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'nav',
			[
				'label'        => esc_html__( 'nav Slider', 'essential-features-addon' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Có', 'essential-features-addon' ),
				'label_off'    => esc_html__( 'Không', 'essential-features-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'dots',
			[
				'label'        => esc_html__( 'Dots Slider', 'essential-features-addon' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Có', 'essential-features-addon' ),
				'label_off'    => esc_html__( 'Không', 'essential-features-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slides',
			[
				'label' => esc_html__( 'Slides', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label'          => esc_html__( 'Content Width', 'essential-features-addon' ),
				'type'           => Controls_Manager::SLIDER,
				'range'          => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units'     => [ '%', 'px' ],
				'default'        => [
					'size' => '66',
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors'      => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_padding',
			[
				'label'      => esc_html__( 'Padding', 'essential-features-addon' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slides_horizontal_position',
			[
				'label'        => esc_html__( 'Horizontal Position', 'essential-features-addon' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'center',
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'essential-features-addon' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'essential-features-addon' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'essential-features-addon' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'element-slides--h-position-',
			]
		);

		$this->add_control(
			'slides_vertical_position',
			[
				'label'        => esc_html__( 'Vertical Position', 'essential-features-addon' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'middle',
				'options'      => [
					'top'    => [
						'title' => esc_html__( 'Top', 'essential-features-addon' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'essential-features-addon' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'essential-features-addon' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'prefix_class' => 'element-slides--v-position-',
			]
		);

		$this->add_control(
			'slides_text_align',
			[
				'label'       => esc_html__( 'Text Align', 'essential-features-addon' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left' => [
						'title' => esc_html__( 'Left', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-left',
					],

					'center' => [
						'title' => esc_html__( 'Center', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-center',
					],

					'right' => [
						'title' => esc_html__( 'Right', 'essential-features-addon' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => 'center',
				'selectors'   => [
					'{{WRAPPER}} .element-slides__item--inner' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'essential-features-addon' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--heading' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .element-slides__item .element-slides__item--heading',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			[
				'label' => esc_html__( 'Description', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'essential-features-addon' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Text Color', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--description' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .element-slides__item .element-slides__item--description',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control( 'button_color',
			[
				'label'     => esc_html__( 'Text Color', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--link, {{WRAPPER}} .element-slides__item .element-slides__item--link a' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .element-slides__item .element-slides__item--link',
			]
		);

		$this->add_control(
			'button_border_width',
			[
				'label'     => esc_html__( 'Border Width', 'essential-features-addon' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--link' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'essential-features-addon' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--link' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'essential-features-addon' ) ] );

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--link, {{WRAPPER}} .element-slides__item .element-slides__item--link a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--link' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover', [ 'label' => esc_html__( 'Hover', 'essential-features-addon' ) ] );

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--link:hover, {{WRAPPER}} .element-slides__item .element-slides__item--link a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--link:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-slides__item .element-slides__item--link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'      => esc_html__( 'Navigation', 'essential-features-addon' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'  => 'nav',
							'value' => 'yes',
						],
						[
							'name'  => 'dots',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label'      => esc_html__( 'Arrows', 'essential-features-addon' ),
				'type'       => Controls_Manager::HEADING,
				'separator'  => 'before',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'nav',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label'      => esc_html__( 'Arrows Size', 'essential-features-addon' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .element-slides.owl-carousel .owl-nav button i.fa' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'nav',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'      => esc_html__( 'Arrows Color', 'essential-features-addon' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .element-slides.owl-carousel .owl-nav button i.fa' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'nav',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_color_hover',
			[
				'label'      => esc_html__( 'Arrows Color Hover', 'essential-features-addon' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .element-slides.owl-carousel .owl-nav button i.fa:hover' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'nav',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label'      => esc_html__( 'Dots', 'essential-features-addon' ),
				'type'       => Controls_Manager::HEADING,
				'separator'  => 'before',
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
			'dots_size',
			[
				'label'      => esc_html__( 'Dots Size', 'essential-features-addon' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 5,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .element-slides.owl-carousel .owl-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
			'dots_color',
			[
				'label'      => esc_html__( 'Dots Color', 'essential-features-addon' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .element-slides.owl-carousel .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
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
				'label'      => esc_html__( 'Dots Color Hover', 'essential-features-addon' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .element-slides.owl-carousel .owl-dots .owl-dot.active span, {{WRAPPER}} .element-slides.owl-carousel .owl-dots .owl-dot:hover span' => 'background-color: {{VALUE}};',
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
		$settings          = $this->get_settings_for_display();
		$data_settings_owl = [
			'items'    => 1,
			'loop'     => ( 'yes' === $settings['loop'] ),
			'autoplay' => ( 'yes' === $settings['autoplay'] ),
			'nav'      => ( 'yes' === $settings['nav'] ),
			'dots'     => ( 'yes' === $settings['dots'] ),
		];
		?>
        <div class="efa-addon-slides custom-owl-carousel owl-carousel owl-theme"
             data-settings-owl='<?php echo wp_json_encode( $data_settings_owl ); ?>'>
			<?php
			foreach ( $settings['slides_list'] as $item ) :
				$efa_slides_link = $item['link'];
				?>
                <div class="efa-addon-slides__item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
                    <div class="efa-addon-slides__item--bg"></div>

                    <div class="efa-addon-slides__item--inner">
						<?php if ( $item['background_overlay'] == 'yes' ) : ?>
                            <div class="efa-addon-slides__item--overlay"></div>
						<?php
						endif;

						if ( $item['show_content'] == 'yes' ) :
							?>
                            <div class="efa-addon-slides__item--content">
								<?php if ( ! empty( $item['heading'] ) ) : ?>
                                    <div class="efa-addon-slides__item--heading">
										<?php echo esc_html( $item['heading'] ); ?>
                                    </div>
								<?php endif; ?>

								<?php if ( ! empty( $item['description'] ) ) : ?>
                                    <div class="efa-addon-slides__item--description">
										<?php echo esc_html( $item['description'] ); ?>
                                    </div>
								<?php endif; ?>

								<?php if ( ! empty( $item['button_text'] ) ) : ?>
                                    <div class="efa-addon-slides__item--link">
										<?php if ( ! empty( $efa_slides_link['url'] ) ) : ?>
                                            <a href="<?php echo esc_url( $efa_slides_link['url'] ); ?>" <?php echo( $efa_slides_link['is_external'] ? 'target="_blank"' : '' ); ?>>
												<?php echo esc_html( $item['button_text'] ); ?>
                                            </a>
										<?php
										else:
											echo esc_html( $item['button_text'] );
										endif;
										?>
                                    </div>
								<?php endif; ?>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
			<?php endforeach; ?>
        </div>
		<?php
	}
}