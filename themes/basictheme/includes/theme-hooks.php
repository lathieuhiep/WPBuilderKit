<?php
/*
 * Action
 * */

// add property
add_action( 'wp_head', 'basictheme_opengraph', 5 );
function basictheme_opengraph(): void {
	global $post;

	if ( is_single() ) :
		if ( has_post_thumbnail( $post->ID ) ) :
			$img_src = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		else :
			$img_src = get_theme_file_uri( '/images/no-image.png' );
		endif;

		$excerpt = $post->post_excerpt;

		if ( $excerpt ) :
			$excerpt = strip_tags( $post->post_excerpt );
			$excerpt = str_replace( "", "'", $excerpt );
		else :
			$excerpt = get_bloginfo( 'description' );
		endif;

		?>
		<meta property="og:url" content="<?php the_permalink(); ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="<?php the_title(); ?>" />
		<meta property="og:description" content="<?php echo esc_attr( $excerpt ); ?>" />
		<meta property="og:image" content="<?php echo esc_url( $img_src ); ?>" />
	<?php
	endif;
}

// Sanitize Pagination
add_action( 'navigation_markup_template', 'basictheme_sanitize_pagination' );
function basictheme_sanitize_pagination( $basictheme_content ): string {
	// Remove role attribute
	$basictheme_content = str_replace( 'role="navigation"', '', $basictheme_content );

	// Remove h2 tag
	return preg_replace( '#<h2.*?>(.*?)<\/h2>#si', '', $basictheme_content );
}

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
		'bootstrap.min.js',
		'owl.carousel.min.js',
		'custom.min.js',
		'elementor-addon.js'
	);

	$src = wp_scripts()->registered[$handle]->src;

	foreach ($async_scripts as $async_script) {
		if ( str_contains( $src, $async_script ) ) {
			return str_replace(' src', ' async="async" src', $tag);
		}
	}

	return $tag;
}