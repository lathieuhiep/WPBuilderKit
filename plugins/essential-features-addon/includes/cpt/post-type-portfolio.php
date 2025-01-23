<?php
function efa_register_ctp_portfolio(): void {
	// register cpt
	$ctp_args = array(
		'labels'        => array(
			'name'               => esc_html__( 'Dự án', 'essential-features-addon' ),
			'singular_name'      => esc_html__( 'Dự án', 'essential-features-addon' ),
			'menu_name'          => esc_html__( 'Dự án', 'essential-features-addon' ),
			'name_admin_bar'     => esc_html__( 'Dự án', 'essential-features-addon' ),
			'add_new'            => esc_html__( 'Thêm mới', 'essential-features-addon' ),
			'add_new_item'       => esc_html__( 'Thêm dự án mới', 'essential-features-addon' ),
			'new_item'           => esc_html__( 'Dự án mới', 'essential-features-addon' ),
			'edit_item'          => esc_html__( 'Chỉnh sửa dự án', 'essential-features-addon' ),
			'view_item'          => esc_html__( 'Xem dự án', 'essential-features-addon' ),
			'all_items'          => esc_html__( 'Tất cả dự án', 'essential-features-addon' ),
			'search_items'       => esc_html__( 'Tìm kiếm dự án', 'essential-features-addon' ),
			'not_found'          => esc_html__( 'Không tìm thấy dự án nào.', 'essential-features-addon' ),
			'not_found_in_trash' => esc_html__( 'Không tìm thấy dự án nào trong thùng rác.', 'essential-features-addon' ),
		),
		'public'        => true,
		'show_ui'       => true,
		'show_in_menu'  => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true,
		'rewrite'       => array( 'slug' => 'du-an' ),
		'show_in_rest'  => true, // Hỗ trợ Gutenberg
		'menu_icon'     => 'dashicons-portfolio'
	);
	register_post_type( 'portfolio', $ctp_args );

	// register taxonomy
	$tax_args = array(
		'hierarchical'      => true,
		'labels'            => array(
			'name'              => esc_html__( 'Danh mục dự án', 'essential-features-addon' ),
			'singular_name'     => esc_html__( 'Danh mục dự án', 'essential-features-addon' ),
			'search_items'      => esc_html__( 'Tìm kiếm danh mục', 'essential-features-addon' ),
			'all_items'         => esc_html__( 'Tất cả danh mục', 'essential-features-addon' ),
			'parent_item'       => esc_html__( 'Danh mục cha', 'essential-features-addon' ),
			'parent_item_colon' => esc_html__( 'Danh mục cha:', 'essential-features-addon' ),
			'edit_item'         => esc_html__( 'Chỉnh sửa danh mục', 'essential-features-addon' ),
			'update_item'       => esc_html__( 'Cập nhật danh mục', 'essential-features-addon' ),
			'add_new_item'      => esc_html__( 'Thêm danh mục mới', 'essential-features-addon' ),
			'new_item_name'     => esc_html__( 'Tên danh mục mới', 'essential-features-addon' ),
			'menu_name'         => esc_html__( 'Danh mục', 'essential-features-addon' ),
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'danh-muc-du-an' ),
	);
	register_taxonomy( 'portfolio_cat', array( 'portfolio' ), $tax_args );

	// Đăng ký Taxonomy: Thẻ dự án
	$tag_args = array(
		'hierarchical'          => false,
		'labels'                => array(
			'name'                       => esc_html__( 'Thẻ dự án', 'essential-features-addon' ),
			'singular_name'              => esc_html__( 'Thẻ dự án', 'essential-features-addon' ),
			'search_items'               => esc_html__( 'Tìm kiếm thẻ', 'essential-features-addon' ),
			'popular_items'              => esc_html__( 'Thẻ phổ biến', 'essential-features-addon' ),
			'all_items'                  => esc_html__( 'Tất cả thẻ', 'essential-features-addon' ),
			'edit_item'                  => esc_html__( 'Chỉnh sửa thẻ', 'essential-features-addon' ),
			'update_item'                => esc_html__( 'Cập nhật thẻ', 'essential-features-addon' ),
			'add_new_item'               => esc_html__( 'Thêm thẻ mới', 'essential-features-addon' ),
			'new_item_name'              => esc_html__( 'Tên thẻ mới', 'essential-features-addon' ),
			'separate_items_with_commas' => esc_html__( 'Ngăn cách các thẻ bằng dấu phẩy.', 'essential-features-addon' ),
			'add_or_remove_items'        => esc_html__( 'Thêm hoặc xóa thẻ', 'essential-features-addon' ),
			'choose_from_most_used'      => esc_html__( 'Chọn từ các thẻ được sử dụng nhiều nhất', 'essential-features-addon' ),
			'menu_name'                  => esc_html__( 'Thẻ', 'essential-features-addon' ),
		),
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'the-du-an' ),
	);
	register_taxonomy( 'portfolio_tag', array( 'portfolio' ), $tag_args );
}

add_action( 'init', 'efa_register_ctp_portfolio' );
