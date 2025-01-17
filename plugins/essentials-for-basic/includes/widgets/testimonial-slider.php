<?php

use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EFB_Widget_Testimonial_Slider extends Widget_Base {

	// widget name
	public function get_name(): string {
		return 'efb-testimonial-slider';
	}

	// widget title
	public function get_title(): string {
		return esc_html__( 'Testimonial Slider', 'essentials-for-basic' );
	}

	// widget icon
	public function get_icon(): string {
		return 'eicon-user-circle-o';
	}

	// widget categories
	public function get_categories(): array {
		return array( 'efb-addons' );
	}

	// widget controls
	protected function register_controls(): void {

		// Content testimonial
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'essentials-for-basic' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'list_title', [
				'label'       => esc_html__( 'Name', 'essentials-for-basic' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'John Doe', 'essentials-for-basic' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_position',
			[
				'label'       => esc_html__( 'Position', 'essentials-for-basic' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Codetic', 'essentials-for-basic' ),
				'label_block' => true
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
			'list_description',
			[
				'label'       => esc_html__( 'Description', 'essentials-for-basic' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 10,
				'default'     => esc_html__( 'GEMs are robotics algorithm for modules that built & optimized for NVIDIA AGX Data should underlie every business decision. Data should underlie every business Yet too often some very down the certain routes.', 'essentials-for-basic' ),
				'placeholder' => esc_html__( 'Type your description here', 'essentials-for-basic' ),
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
						'list_title' => esc_html__( 'Title #1', 'essentials-for-basic' ),
					],
					[
						'list_title' => esc_html__( 'Title #2', 'essentials-for-basic' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();

		// Content additional options
		$this->start_controls_section(
			'additional_options_section',
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

		$this->end_controls_section();

	}

	// widget output on the frontend
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		$data_settings_owl = [
			'loop'     => ( 'yes' === $settings['loop'] ),
			'nav'      => ( 'yes' === $settings['nav'] ),
			'dots'     => ( 'yes' === $settings['dots'] ),
			'autoplay' => ( 'yes' === $settings['autoplay'] ),
			'items'    => 1
		];
		?>

        <div class="element-testimonial-slider">
            <div class="custom-owl-carousel owl-carousel owl-theme"
                 data-settings-owl='<?php echo wp_json_encode( $data_settings_owl ); ?>'>
				<?php
				foreach ( $settings['list'] as $item ) :
					$imageId = $item['list_image']['id'];
					?>

                    <div class="item text-center elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
                        <div class="item__image">
							<?php
							if ( $imageId ) :
								echo wp_get_attachment_image( $item['list_image']['id'], array( '150', '150' ) );
							else:
								?>
                                <img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/user-avatar.png' ) ) ?>"
                                     alt="<?php echo esc_attr( $item['list_title'] ); ?>"/>
							<?php endif; ?>
                        </div>

                        <div class="item__content">
                            <div class="desc">
								<?php echo wp_kses_post( $item['list_description'] ) ?>
                            </div>

                            <div class="name">
								<?php echo esc_html( $item['list_title'] ); ?>
                            </div>

                            <div class="position">
								<?php echo esc_html( $item['list_position'] ); ?>
                            </div>
                        </div>
                    </div>

				<?php endforeach; ?>
            </div>
        </div>

		<?php
	}
}