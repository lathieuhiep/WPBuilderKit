<?php
// image size options
function efa_image_size_options(): array
{
	return [
		'thumbnail' => esc_html__('Thumbnail (150 x 150)', 'essential-features-addon'),
		'medium' => esc_html__('Medium(300 x 300)', 'essential-features-addon'),
		'medium_large' => esc_html__('Medium Large(768 x 0)', 'essential-features-addon'),
		'large' => esc_html__('Large(1024 x 1024)', 'essential-features-addon'),
		'full' => esc_html__('Full Size(Kích thước gốc)', 'essential-features-addon'),
	];
}

// image object position
function efa_image_object_position_options(): array {
	return [
		'center center' => esc_html__( 'Chính giữa', 'essential-features-addon' ),
		'center left' => esc_html__( 'Ở giữa bên trái', 'essential-features-addon' ),
		'center right' => esc_html__( 'Ở giữa bên phải', 'essential-features-addon' ),
		'top center' => esc_html__( 'Trên cùng ở giữa', 'essential-features-addon' ),
		'top left' => esc_html__( 'Trên cùng bên trái', 'essential-features-addon' ),
		'top right' => esc_html__( 'Trên cùng bên phải', 'essential-features-addon' ),
		'bottom center' => esc_html__( 'Phía dưới ở giữa', 'essential-features-addon' ),
		'bottom left' => esc_html__( 'Phía dưới bên trái', 'essential-features-addon' ),
		'bottom right' => esc_html__( 'Phía dưới bên phải', 'essential-features-addon' ),
	];
}

// html tag options
function efa_html_tag_options(): array {
	return [
		'h1' => 'H1',
		'h2' => 'H2',
		'h3' => 'H3',
		'h4' => 'H4',
		'h5' => 'H5',
		'h6' => 'H6'
	];
}