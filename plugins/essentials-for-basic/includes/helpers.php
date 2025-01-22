<?php
// Get Category Check Box
function efb_check_get_cat( $type_taxonomy ): array {
	$cat_check = array();
	$category  = get_terms(
		array(
			'taxonomy'   => $type_taxonomy,
			'hide_empty' => false
		)
	);

	if ( ! empty( $category ) ):
		foreach ( $category as $item ) {
			$cat_check[ $item->term_id ] = $item->name;
		}
	endif;

	return $cat_check;
}

// Get Contact Form 7
function efb_get_form_cf7(): array {
	$options = array();

	if ( function_exists( 'wpcf7' ) ) {

		$wpcf7_form_list = get_posts( array(
			'post_type'   => 'wpcf7_contact_form',
			'numberposts' => - 1,
		) );

		$options[0] = esc_html__( 'Select a Contact Form', 'essentials-for-basic' );

		if ( ! empty( $wpcf7_form_list ) && ! is_wp_error( $wpcf7_form_list ) ) :
			foreach ( $wpcf7_form_list as $item ) :
				$options[ $item->ID ] = $item->post_title;
			endforeach;
		else :
			$options[0] = esc_html__( 'Create a Form First', 'essentials-for-basic' );
		endif;

	}

	return $options;
}

// image size options
function efb_image_size_options(): array
{
	return [
		'thumbnail' => esc_html__('Thumbnail (150 x 150)', 'essentials-for-basic'),
		'medium' => esc_html__('Medium(300 x 300)', 'essentials-for-basic'),
		'medium_large' => esc_html__('Medium Large(768 x 0)', 'essentials-for-basic'),
		'large' => esc_html__('Large(1024 x 1024)', 'essentials-for-basic'),
		'full' => esc_html__('Full Size(Kích thước gốc)', 'essentials-for-basic'),
	];
}

// image object position
function efb_image_object_position_options(): array {
	return [
		'center center' => esc_html__( 'Chính giữa', 'essentials-for-basic' ),
		'center left' => esc_html__( 'Ở giữa bên trái', 'essentials-for-basic' ),
		'center right' => esc_html__( 'Ở giữa bên phải', 'essentials-for-basic' ),
		'top center' => esc_html__( 'Trên cùng ở giữa', 'essentials-for-basic' ),
		'top left' => esc_html__( 'Trên cùng bên trái', 'essentials-for-basic' ),
		'top right' => esc_html__( 'Trên cùng bên phải', 'essentials-for-basic' ),
		'bottom center' => esc_html__( 'Phía dưới ở giữa', 'essentials-for-basic' ),
		'bottom left' => esc_html__( 'Phía dưới bên trái', 'essentials-for-basic' ),
		'bottom right' => esc_html__( 'Phía dưới bên phải', 'essentials-for-basic' ),
	];
}