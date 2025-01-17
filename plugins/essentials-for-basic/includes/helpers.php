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