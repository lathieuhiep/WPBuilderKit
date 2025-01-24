<?php
// Get Category Check Box
function efa_check_get_cat( $type_taxonomy ): array {
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
function efa_get_form_cf7(): array {
	$options = array();

	if ( function_exists( 'wpcf7' ) ) {

		$wpcf7_form_list = get_posts( array(
			'post_type'   => 'wpcf7_contact_form',
			'numberposts' => - 1,
		) );

		$options[0] = esc_html__( 'Select a Contact Form', 'essential-features-addon' );

		if ( ! empty( $wpcf7_form_list ) && ! is_wp_error( $wpcf7_form_list ) ) :
			foreach ( $wpcf7_form_list as $item ) :
				$options[ $item->ID ] = $item->post_title;
			endforeach;
		else :
			$options[0] = esc_html__( 'Create a Form First', 'essential-features-addon' );
		endif;

	}

	return $options;
}

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

// pagination
function efa_pagination(): void {
	the_posts_pagination( array(
		'type'               => 'list',
		'mid_size'           => 2,
		'prev_text'          => esc_html__( 'Trước', 'essential-features-addon' ),
		'next_text'          => esc_html__( 'Sau', 'essential-features-addon' ),
		'screen_reader_text' => '&nbsp;',
	) );
}