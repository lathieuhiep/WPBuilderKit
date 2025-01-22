<?php

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class EFB_Widget_Heading_With_Editor extends Widget_Base {

	// widget name
	public function get_name(): string {
		return 'efb-heading-with-editor';
	}

	// widget title
	public function get_title(): string {
		return esc_html__( 'Tiêu đề và văn bản', 'essentials-for-basic' );
	}

	// widget icon
	public function get_icon(): string {
		return 'eicon-pencil';
	}

	// widget categories
	public function get_categories(): array {
		return array( 'efb-addons' );
	}

	// widget keywords
	public function get_keywords(): array
	{
		return ['heading', 'editor', 'text'];
	}

	// widget controls
	protected function register_controls(): void {
		// Content
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Nội dung', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Tiêu đề', 'essentials-for-basic' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Tiêu đề', 'essentials-for-basic' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label'   => esc_html__( 'HTML Tag', 'essentials-for-basic' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6'
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Văn bản', 'essentials-for-basic' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Nội dung văn bản', 'essentials-for-basic' ),
			]
		);

		$this->end_controls_section();

		// Style Heading
		$this->start_controls_section(
			'style_heading',
			[
				'label' => esc_html__( 'Tiêu đề', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'heading_align',
			[
				'label'     => esc_html__( 'Căn chỉnh', 'essentials-for-basic' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => esc_html__( 'Trái', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-left',
					],

					'center' => [
						'title' => esc_html__( 'Giữa', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-center',
					],

					'right' => [
						'title' => esc_html__( 'Phải', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-right',
					],

					'justify' => [
						'title' => esc_html__( 'Căn đều hai lề', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .element-heading-with-editor .heading' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Màu', 'essentials-for-basic' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-heading-with-editor .heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Kiểu chữ', 'essentials-for-basic' ),
				'selector' => '{{WRAPPER}} .element-heading-with-editor .heading',
			]
		);

		$this->end_controls_section();

		// Style Heading
		$this->start_controls_section(
			'style_description',
			[
				'label' => esc_html__( 'Văn bản', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'desc_align',
			[
				'label'     => esc_html__( 'Căn chỉnh', 'essentials-for-basic' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => esc_html__( 'Trái', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-left',
					],

					'center' => [
						'title' => esc_html__( 'Giữa', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-center',
					],

					'right' => [
						'title' => esc_html__( 'Phải', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-right',
					],

					'justify' => [
						'title' => esc_html__( 'Căn đều hai lề', 'essentials-for-basic' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .element-heading-with-editor .desc' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Color', 'essentials-for-basic' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .element-heading-with-editor .desc' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'label'    => esc_html__( 'Kiểu chữ', 'essentials-for-basic' ),
				'selector' => '{{WRAPPER}} .element-heading-with-editor .desc',
			]
		);

		$this->end_controls_section();
	}

	// widget output on the frontend
	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$tag = $settings['html_tag'];
		?>
        <div class="element-heading-with-editor">
            <?php if ( $settings['heading'] ) : ?>
                <<?php echo esc_html( $tag ); ?> class="heading">
		            <?php echo esc_html( $settings['heading'] ); ?>
                </<?php echo esc_html( $tag ); ?>>
            <?php endif; ?>

			<?php if ( ! empty( $settings['description'] ) ) : ?>
                <div class="desc">
					<?php echo wpautop( $settings['description'] ); ?>
                </div>
			<?php endif; ?>
        </div>
		<?php
	}

	protected function content_template() {
		?>
        <#
        var tag = settings.html_tag;
        #>

        <div class="element-heading-with-editor">
            <{{{ tag }}} class="heading">
                {{{ settings.heading }}}
            </{{{ tag }}}>

            <# if ( '' !== settings.description ) {#>
                <div class="desc">
                    {{{ settings.description }}}
                </div>
            <# } #>
        </div>
		<?php
	}

}