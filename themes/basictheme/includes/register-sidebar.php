<?php
// Remove gutenberg widgets
add_filter('use_widgets_block_editor', '__return_false');

/* Better way to add multiple widgets areas */
function basictheme_widget_registration($name, $id, $description = ''): void {
	register_sidebar( array(
		'name' => $name,
		'id' => $id,
		'description' => $description,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
}

function basictheme_multiple_widget_init(): void {
	basictheme_widget_registration( esc_html__('Sidebar Main', 'basictheme'), 'sidebar-main' );
	basictheme_widget_registration( esc_html__('Sidebar Shop', 'basictheme'), 'sidebar-wc', esc_html__('Display sidebar on page shop.', 'basictheme') );
	basictheme_widget_registration( esc_html__('Sidebar Product', 'basictheme'), 'sidebar-wc-product', esc_html__('Display sidebar on page single product.', 'basictheme') );

	// sidebar footer
	$opt_number_columns = basictheme_get_option('opt_footer_columns', '4');
	for ( $i = 1; $i <= $opt_number_columns; $i++ ) {
		basictheme_widget_registration( esc_html__('Sidebar Footer Column ' . $i, 'basictheme'), 'sidebar-footer-column-' . $i );
	}
}

add_action('widgets_init', 'basictheme_multiple_widget_init');