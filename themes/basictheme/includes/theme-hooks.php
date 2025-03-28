<?php
/*
 * Action
 * */

//Disable emojis in WordPress
add_action( 'init', 'basictheme_disable_emojis' );
function basictheme_disable_emojis(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'basictheme_disable_emojis_tinymce' );
}

function basictheme_disable_emojis_tinymce( $plugins ): array {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

// Load preconnect and preload for fonts and fontawesome
add_action( 'wp_head', function() {
	// Preconnect and preload for Google Fonts
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
	echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto+Slab:wght@400;500;700&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';

	// Preconnect and preload for Font Awesome
	echo '<link rel="preconnect" href="https://cdnjs.cloudflare.com">';
	echo '<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>';
	echo '<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
}, 5);


// add code to head
function basictheme_custom_header_code(): void {
	$header_code = basictheme_get_option( 'opt_header_code' );

	if ($header_code) {
		echo $header_code;
	}
}
add_action('wp_head', 'basictheme_custom_header_code');

// add code to body
function basictheme_custom_body_code(): void {
	$body_code = basictheme_get_option( 'opt_body_code' );

	if ($body_code) {
		echo $body_code;
	}
}
add_action('wp_body_open', 'basictheme_custom_body_code');

// add code to footer
function basictheme_custom_footer_code(): void {
	$footer_code = basictheme_get_option( 'opt_footer_code' );

	if ($footer_code) {
		echo $footer_code;
	}
}
add_action('wp_footer', 'basictheme_custom_footer_code');

/*
 * Filter
 * */

// disable gutenberg editor
add_filter("use_block_editor_for_post_type", "disable_gutenberg_editor");
function disable_gutenberg_editor(): bool {
	return false;
}

// disable gutenberg widgets
add_filter('use_widgets_block_editor', '__return_false');

// Walker for the main menu
add_filter( 'walker_nav_menu_start_el', 'basictheme_add_arrow',10,4);
function basictheme_add_arrow( $output, $item, $depth, $args ){
	if('primary' == $args->theme_location && $depth >= 0 ){
		if (in_array("menu-item-has-children", $item->classes)) {
			$output .='<span class="sub-menu-toggle"></span>';
		}
	}

	return $output;
}