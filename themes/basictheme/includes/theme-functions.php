<?php
// get version theme
function basictheme_get_version_theme(): string {
	return wp_get_theme()->get( 'Version' );
}

// set favicon default
if ( ! function_exists( 'basictheme_fallback_favicon' ) ) {
    add_action( 'wp_head', 'basictheme_fallback_favicon' );
    function basictheme_fallback_favicon(): void
    {
        if ( ! has_site_icon() ) {
            $base_favicon_url = get_theme_file_uri( '/assets/images/favicons/' );
        ?>
            <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( $base_favicon_url . 'apple-touch-icon.png' ) ?>">
            <link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( $base_favicon_url . 'favicon-96x96.png' ) ?>">
            <link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url( $base_favicon_url . 'favicon-96x96.png' ) ?>">
            <link rel="icon" type="image/x-icon" href="<?php echo esc_url($base_favicon_url . 'favicon.ico') ?>">
            <link rel="manifest" href="<?php echo esc_url($base_favicon_url . 'site.webmanifest') ?>">
            <link rel="icon" type="image/svg+xml" href="<?php echo esc_url($base_favicon_url . 'favicon.svg') ?>">
        <?php
        }
    }
}

// check is blog
function basictheme_is_blog(): bool {
    return ( is_home() || ( is_archive() && get_post_type() === 'post' ) || ( is_search() && get_post_type() === 'post' ) );
}

// Callback Comment List
function basictheme_comments( $basictheme_comment, $basictheme_comment_args, $basictheme_comment_depth ): void {
	if ( $basictheme_comment_args['style'] == 'div' ) :
		$basictheme_comment_tag       = 'div';
		$basictheme_comment_add_below = 'comment';
	else :
		$basictheme_comment_tag       = 'li';
		$basictheme_comment_add_below = 'div-comment';
	endif;

	?>
    <<?php echo $basictheme_comment_tag . ' ' ?><?php comment_class( empty( $basictheme_comment_args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">

	<?php if ( 'div' != $basictheme_comment_args['style'] ) : ?>

        <div id="div-comment-<?php comment_ID() ?>" class="comment__body">

	<?php endif; ?>
    <div class="author vcard">
        <div class="author__avatar">
			<?php if ( $basictheme_comment_args['avatar_size'] != 0 ) {
				echo get_avatar( $basictheme_comment, $basictheme_comment_args['avatar_size'] );
			} ?>
        </div>

        <div class="author__info">
            <span class="name"><?php comment_author_link(); ?></span>

            <span class="date"><?php comment_date(); ?></span>
        </div>
    </div>

	<?php if ( $basictheme_comment->comment_approved == '0' ) : ?>
        <div class="awaiting">
			<?php esc_html_e( 'Bình luận của bạn đang chờ kiểm duyệt.', 'basictheme' ); ?>
        </div>
	<?php endif; ?>

    <div class="content">
		<?php comment_text(); ?>
    </div>

    <div class="action">
		<?php edit_comment_link( esc_html__( 'Sửa ', 'basictheme' ) ); ?>

		<?php comment_reply_link( array_merge( $basictheme_comment_args, array(
			'add_below' => $basictheme_comment_add_below,
			'depth'     => $basictheme_comment_depth,
			'max_depth' => $basictheme_comment_args['max_depth']
		) ) ); ?>
    </div>

	<?php if ( $basictheme_comment_args['style'] != 'div' ) : ?>

        </div>

	<?php
	endif;
}

// Content Nav
function basictheme_comment_nav(): void {
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
        <nav class="navigation comment-navigation">
            <h2 class="screen-reader-text">
				<?php esc_html_e( 'Điều hướng bình luận', 'basictheme' ); ?>
            </h2>

            <div class="nav-links">
				<?php
				if ( $prev_link = get_previous_comments_link( esc_html__( 'Bình luận cũ hơn', 'basictheme' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( esc_html__( 'Bình luận mới hơn', 'basictheme' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
				?>
            </div>
        </nav>
	<?php
	endif;
}

// Pagination
function basictheme_pagination(): void {
	the_posts_pagination( array(
		'type'               => 'list',
		'mid_size'           => 2,
		'prev_text'          => esc_html__( 'Trước', 'basictheme' ),
		'next_text'          => esc_html__( 'Sau', 'basictheme' ),
		'screen_reader_text' => '&nbsp;',
	) );
}

// Pagination Nav Query
function basictheme_paging_nav_query( $query ): void {
	$args = array(
		'prev_text' => esc_html__( ' Trước', 'basictheme' ),
		'next_text' => esc_html__( 'Sau', 'basictheme' ),
		'current'   => max( 1, get_query_var( 'paged' ) ),
		'total'     => $query->max_num_pages,
		'type'      => 'list',
	);

	$paginate_links = paginate_links( $args );

	if ( $paginate_links ) :
		?>
        <nav class="pagination">
			<?php echo $paginate_links; ?>
        </nav>
	<?php
	endif;
}

// Get col global
function basictheme_col_use_sidebar( $option_sidebar, $active_sidebar ): string {
	if ( $option_sidebar != 'hide' && is_active_sidebar( $active_sidebar ) ):

		if ( $option_sidebar == 'left' ) :
			$class_position_sidebar = ' order-1 order-md-2';
		else:
			$class_position_sidebar = ' order-1';
		endif;

		$class_col_content = 'col-12 col-md-8 col-lg-9' . $class_position_sidebar;
	else:
		$class_col_content = 'col-md-12';
	endif;

	return $class_col_content;
}

function basictheme_col_sidebar(): string {
	return 'col-12 col-md-4 col-lg-3';
}

// Post Meta
function basictheme_post_meta(): void {
?>
    <div class="post-meta d-flex flex-wrap gap-1">
        <div class="post-meta__item post-meta__author">
            <strong class="theme-fw-medium"><?php esc_html_e( 'Tác giả:', 'basictheme' ); ?></strong>

            <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
                <?php the_author(); ?>
            </a>
        </div>

        <div class="post-meta__item post-meta__date">
            <strong class="theme-fw-medium"><?php esc_html_e( 'Ngày đăng: ', 'basictheme' ); ?></strong>
            <span><?php echo get_the_date(); ?></span>
        </div>

        <div class="post-meta__item post-meta__comments">
            <?php
            comments_popup_link( '0 ' . esc_html__( 'Bình luận', 'basictheme' ), '1 ' . esc_html__( 'Bình luận', 'basictheme' ), '% ' . esc_html__( 'Bình luận', 'basictheme' ) );
            ?>
        </div>
    </div>
<?php
}

// Link Pages
function basictheme_link_page(): void {
	wp_link_pages( array(
		'before'      => '<div class="page-links">' . esc_html__( 'Trang:', 'basictheme' ),
		'after'       => '</div>',
		'link_before' => '<span class="page-number">',
		'link_after'  => '</span>',
	) );
}

// Get Contact Form 7
function basictheme_get_form_cf7(): array {
	$options = array();

	if ( function_exists( 'wpcf7' ) ) {

		$wpcf7_form_list = get_posts( array(
			'post_type'   => 'wpcf7_contact_form',
			'numberposts' => - 1,
		) );

		$options[0] = esc_html__( 'Chọn một mẫu liên hệ', 'basictheme' );

		if ( ! empty( $wpcf7_form_list ) && ! is_wp_error( $wpcf7_form_list ) ) :
			foreach ( $wpcf7_form_list as $item ) :
				$options[ $item->ID ] = $item->post_title;
			endforeach;
		else :
			$options[0] = esc_html__( 'Tạo biểu mẫu trước tiên', 'basictheme' );
		endif;

	}

	return $options;
}

// list social network
function basictheme_list_social_network(): array {
	return array(
		'facebook-f'  => 'Facebook',
		'twitter'     => 'Twitter',
		'linkedin-in' => 'Linkedin',
		'youtube'     => 'Youtube',
		'instagram'   => 'Instagram'
	);
}

function basictheme_get_social_url(): void {
	$opt_social_networks = basictheme_get_option( 'opt_social_networks' );

	if ( ! empty( $opt_social_networks ) ) :
		foreach ( $opt_social_networks as $item ) :
			if ( empty( $item['item'] ) ) {
				continue;
			}
			?>
            <div class="social-network-item">
                <a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank">
                    <i class="ic-mask ic-mask-<?php echo esc_attr( $item['item'] ); ?>"></i>
                </a>
            </div>
		<?php

		endforeach;
	endif;
}

// replace number
function basictheme_preg_replace_ony_number( $string ): string|null {
	$number = '';

	if ( ! empty( $string ) ) {
		$number = preg_replace( '/[^0-9]/', '', strip_tags( $string ) );
	}

	return $number;
}

// Create a function to fetch all post categories and return them as an associative array for use in a select dropdown
function basictheme_get_all_categories(): array {
	$categories = get_categories( array(
		'hide_empty' => 0,
	) );

	$categories_list = array();
	foreach ( $categories as $category ) {
		$categories_list[ $category->term_id ] = $category->name;
	}

	return $categories_list;
}