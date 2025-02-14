<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class EFA_Widget_Contact_Form_7 extends Widget_Base {

	// widget name
	public function get_name(): string {
		return 'efa-contact-form-7';
	}

	// widget title
	public function get_title(): string {
		return esc_html__( 'Contact Form 7', 'essential-features-addon' );
	}

	// widget icon
	public function get_icon(): string {
		return 'eicon-form-horizontal';
	}

	// widget categories
	public function get_categories(): array {
		return array( 'efa-addons' );
	}

	// widget controls
	protected function register_controls(): void {
		// Content section
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Form liên hệ', 'essential-features-addon' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'contact_form_list',
			[
				'label'       => esc_html__( 'Chọn mẫu liên hệ', 'essential-features-addon' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => efa_get_form_cf7(),
				'default'     => '0',
			]
		);

		$this->end_controls_section();
	}

	// widget output on the frontend
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['contact_form_list'] ) ) :
			?>

            <div class="efa-addon-contact-form-7">
				<?php echo do_shortcode( '[contact-form-7 id="' . $settings['contact_form_list'] . '" ]' ); ?>
            </div>

		<?php
		endif;
	}
}