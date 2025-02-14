<?php

use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EFA_Widget_Testimonial_Slider extends Widget_Base {

	// widget name
	public function get_name(): string {
		return 'efa-testimonial-slider';
	}

	// widget title
	public function get_title(): string {
		return esc_html__( 'Slider lời chứng thực', 'essential-features-addon' );
	}

	// widget icon
	public function get_icon(): string {
		return 'eicon-user-circle-o';
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

		// Content testimonial
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Nội dung', 'essential-features-addon' ),
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
				'default'     => esc_html__( 'John Doe', 'essential-features-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_position',
			[
				'label'       => esc_html__( 'Vị trí', 'essential-features-addon' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Vị trí', 'essential-features-addon' ),
				'label_block' => true
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
			'list_description',
			[
				'label'       => esc_html__( 'Văn bản', 'essential-features-addon' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 10,
				'default'     => esc_html__( 'GEMs are robotics algorithm for modules that built & optimized for NVIDIA AGX Data should underlie every business decision. Data should underlie every business Yet too often some very down the certain routes.', 'essential-features-addon' ),
				'placeholder' => esc_html__( 'Nhập văn bản', 'essential-features-addon' ),
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
						'list_title' => esc_html__( 'Tiêu đề #1', 'essential-features-addon' ),
					],
					[
						'list_title' => esc_html__( 'Tiêu đề #2', 'essential-features-addon' ),
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
				'label'   => esc_html__( 'Thanh điều hướng', 'essential-features-addon' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'   => esc_html__( 'Mũi tên và Dấu chấm', 'essential-features-addon' ),
					'arrows' => esc_html__( 'Mũi tên', 'essential-features-addon' ),
					'dots'   => esc_html__( 'Dấu chấm', 'essential-features-addon' ),
					'none'   => esc_html__( 'Không', 'essential-features-addon' ),
				],
			]
		);

		$this->end_controls_section();

	}

	// widget output on the frontend
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		$data_settings_owl = [
			'items'    => 1,
			'loop'     => ( 'yes' === $settings['loop'] ),
			'nav'      => $settings['navigation'] == 'both' || $settings['navigation'] == 'arrows',
			'dots'     => $settings['navigation'] == 'both' || $settings['navigation'] == 'dots',
			'autoplay' => ( 'yes' === $settings['autoplay'] )
		];
		?>

        <div class="efa-addon-testimonial-slider">
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
								echo wp_get_attachment_image( $item['list_image']['id'], $settings['image_size'] );
							else:
								?>
                                <img src="<?php echo esc_url( EFA_PLUGIN_URL . 'assets/images/user-avatar.png' ); ?>"
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