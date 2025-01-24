<?php
/* Better way to add multiple widgets areas */
function basictheme_register_sidebar( $name, $id, $description = '' ): void {
	register_sidebar( array(
		'name'          => $name,
		'id'            => $id,
		'description'   => $description,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'basictheme_multiple_widget_init' );
function basictheme_multiple_widget_init(): void {
	basictheme_register_sidebar( esc_html__( 'Sidebar Chính', 'basictheme' ), 'sidebar-main', 'Dùng ở các trang bài viết' );

	basictheme_register_sidebar( esc_html__( 'Sidebar Shop', 'basictheme' ), 'sidebar-wc', esc_html__( 'Dùng ở trang danh mục sản phẩm.', 'basictheme' ) );

	basictheme_register_sidebar( esc_html__( 'Sidebar Product', 'basictheme' ), 'sidebar-wc-product', esc_html__( 'Dùng cho trang chi tiết sản phẩm', 'basictheme' ) );

	// sidebar footer
	$opt_number_columns = basictheme_get_option( 'opt_footer_columns', '4' );
	for ( $i = 1; $i <= $opt_number_columns; $i ++ ) {
		basictheme_register_sidebar( esc_html__( 'Sidebar Footer Column ' . $i, 'basictheme' ), 'sidebar-footer-column-' . $i, 'Dùng ở chân trang' );
	}
}