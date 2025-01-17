<?php

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class EFB_Widget_About_Text extends Widget_Base {

	// widget name
	public function get_name(): string {
		return 'efb-about-text';
	}

	// widget title
	public function get_title(): string {
		return esc_html__( 'About Text', 'essentials-for-basic' );
	}

	// widget icon
	public function get_icon(): string {
		return 'eicon-text-area';
	}

	// widget categories
	public function get_categories(): array {
		return array( 'efb-addons' );
	}

	// widget controls
	protected function register_controls(): void {
		// Content heading
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Heading', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Heading', 'essentials-for-basic' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Heading About Text', 'essentials-for-basic' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'essentials-for-basic' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Default description', 'essentials-for-basic' ),
			]
		);

		$this->end_controls_section();

		// Style Heading
		$this->start_controls_section(
			'style_heading',
			[
				'label' => esc_html__( 'Heading', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'align',
			[
				'label'     => esc_html__( 'Alignment Title', 'essentials-for-basic' ),
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
				'selectors' => [
					'{{WRAPPER}} .element-about-text' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Color', 'essentials-for-basic' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-about-text__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Typography', 'essentials-for-basic' ),
				'selector' => '{{WRAPPER}} .element-about-text__title',
			]
		);

		$this->end_controls_section();

		// Style Heading
		$this->start_controls_section(
			'style_description',
			[
				'label' => esc_html__( 'Description', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => __( 'Color', 'essentials-for-basic' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-about-text__description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'    => __( 'Typography', 'essentials-for-basic' ),
				'selector' => '{{WRAPPER}} .element-about-text__description',
			]
		);

		$this->end_controls_section();
	}

	// widget output on the frontend
	protected function render(): void {
		$settings = $this->get_settings_for_display();
		?>
        <div class="element-about-text">
            <h2 class="element-about-text__title">
				<?php echo wp_kses_post( $settings['heading'] ); ?>
            </h2>

			<?php if ( ! empty( $settings['description'] ) ) : ?>

                <div class="element-about-text__description">
					<?php echo wpautop( $settings['description'] ); ?>
                </div>

			<?php endif; ?>
        </div>
		<?php
	}

	protected function content_template() {
		?>
        <div class="element-about-text">
            <h2 class="element-about-text__title">
                {{{ settings.heading }}}
            </h2>

            <# if ( '' !== settings.description ) {#>

            <div class="element-about-text__description">
                {{{ settings.description }}}
            </div>

            <# } #>
        </div>
		<?php
	}

}