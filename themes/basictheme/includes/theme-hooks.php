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

// add async file scrip
add_filter('script_loader_tag', 'add_async_attribute', 10, 2);
function add_async_attribute($tag, $handle) {
	$async_scripts = array(
		'bootstrap.bundle.min.js',
		'owl.carousel.min.js',
		'custom.min.js'
	);

	$src = wp_scripts()->registered[$handle]->src;

	foreach ($async_scripts as $async_script) {
		if ( str_contains( $src, $async_script ) ) {
			return str_replace(' src', ' async="async" src', $tag);
		}
	}

	return $tag;
}