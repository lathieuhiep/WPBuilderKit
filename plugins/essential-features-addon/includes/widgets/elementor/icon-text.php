<?php

use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class EFA_Widget_Icon_Text extends Widget_Base {

	// widget name
	public function get_name(): string {
		return 'icon-text';
	}

	// widget title
	public function get_title(): string {
		return esc_html__( 'Icon và Nội dung', 'essential-features-addon' );
	}

	// widget icon
	public function get_icon(): string {
		return 'eicon-icon-box';
	}

	// widget categories
	public function get_categories(): array {
		return array( 'efa-addons' );
	}

	// widget keywords
	public function get_keywords(): array
	{
		return ['icon', 'text'];
	}

	// widget controls
	protected function register_controls(): void {
		// Content
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Nội dung', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'icon',
			[
				'name'    => 'icon',
				'label'   => esc_html__( 'Icon', 'essential-features-addon' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
			],
		);

		$this->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Tiêu đề', 'essential-features-addon' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Tiêu đề', 'essential-features-addon' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'content',
			[
				'name' => 'content',
				'label' => esc_html__( 'Văn bản', 'essential-features-addon' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'List Content' , 'essential-features-addon' ),
				'show_label' => false,
			],
		);

		$this->add_control(
			'heading_tag',
			[
				'label'   => esc_html__( 'Tiêu đề thẻ HTML', 'essential-features-addon' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => efa_text_wrapper_tag_options(),
			]
		);

		$this->end_controls_section();

        // style box
		$this->start_controls_section(
			'style_box',
			[
				'label' => esc_html__( 'Hộp', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__( 'Khoảng cách các Icon', 'essential-features-addon' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'max' => 100,
					],
					'em' => [
						'max' => 10,
					],
					'rem' => [
						'max' => 10,
					],
				],
				'default' => [
					'unit' => 'rem',
					'size' => 2.4,
				],
				'selectors' => [
					'{{WRAPPER}} .efa-addon-ic-txt' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_spacer',
			[
				'label' => esc_html__( 'Khoảng cách nội dung', 'essential-features-addon' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'px' => [
						'max' => 100,
					],
					'em' => [
						'max' => 10,
					],
					'rem' => [
						'max' => 10,
					],
				],
				'default' => [
					'unit' => 'rem',
					'size' => 1.2,
				],
				'selectors' => [
					'{{WRAPPER}} .text-box' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

        // style icon
		$this->start_controls_section(
			'style_icon',
			[
				'label' => esc_html__( 'Icon', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'label' => esc_html__( 'Độ rộng', 'essential-features-addon' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'rem',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .icon-box' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Màu', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .icon-box' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// Style heading
		$this->start_controls_section(
			'style_heading',
			[
				'label' => esc_html__( 'Tiêu đề', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Màu', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .text-box .heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Kiểu chữ', 'essential-features-addon' ),
				'selector' => '{{WRAPPER}} .text-box .heading',
			]
		);

		$this->end_controls_section();

		// Style desc
		$this->start_controls_section(
			'style_description',
			[
				'label' => esc_html__( 'Văn bản', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Color', 'essential-features-addon' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .text-box .content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'label'    => esc_html__( 'Kiểu chữ', 'essential-features-addon' ),
				'selector' => '{{WRAPPER}} .text-box .content',
			]
		);

		$this->end_controls_section();
	}

	// widget output on the frontend
	protected function render(): void {
		$settings = $this->get_settings_for_display();

        // controls
		$heading_tag = $settings['heading_tag'];
	?>
		<div class="efa-addon-ic-txt efa-flex">
            <div class="icon-box">
                <?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </div>

            <div class="text-box efa-flex efa-flex-column efa-flex-grow-1">
                <?php
                printf(
                    '<%1$s class="heading efa-m-0">%2$s</%1$s>',
                    esc_attr( $heading_tag ),
                    esc_html( $settings['heading'] )
                );
                ?>

                <div class="content">
                    <?php echo wpautop( $settings['content'] ); ?>
                </div>
            </div>
		</div>
	<?php
	}

	protected function content_template() {
    ?>
        <#
        iconHTML = elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i' , 'object' ),
        #>
        <div class="efa-addon-ic-txt efa-flex">
            <div class="icon-box">
                {{{ elementor.helpers.sanitize( iconHTML.value ) }}}
            </div>

            <div class="text-box efa-flex efa-flex-column efa-flex-grow-1">
                <{{{ settings.heading_tag }}} class="heading efa-m-0">{{{ settings.heading }}}</{{{ settings.heading_tag }}}>

                <div class="content">
                    {{{ settings.content }}}
                </div>
            </div>
        </div>
    <?php
	}
}