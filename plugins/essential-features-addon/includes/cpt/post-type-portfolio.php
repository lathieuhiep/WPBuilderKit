<?php
// Register Custom Post Type Portfolio
function efa_register_portfolio_post_type(): void {
	$args = array(
		'label'         => 'Portfolio',
		'description'   => 'Portfolio items for showcasing projects.',
		'public'        => true,
		'show_ui'       => true,
		'show_in_menu'  => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail' ),
		'has_archive'   => true,
		'rewrite'       => array( 'slug' => 'portfolio' ),
		'show_in_rest'  => true, // Hỗ trợ Gutenberg
	);
	register_post_type( 'portfolio', $args );
}

add_action( 'init', 'efa_register_portfolio_post_type' );
