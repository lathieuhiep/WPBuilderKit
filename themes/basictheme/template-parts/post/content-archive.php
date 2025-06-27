<?php
$sidebar = basictheme_get_option('opt_post_cat_sidebar_position', 'right');
$per_row = basictheme_get_option('opt_post_cat_per_row', 3);
$class_col_content = basictheme_col_use_sidebar($sidebar, 'sidebar-main');

if ( empty( $per_row ) ) {
    $per_row = [
        'sm' => 1,
        'md' => 2,
        'lg' => 3,
        'xl' => 3
    ];
}

$per_row_classes = sprintf(
    'theme-row-cols-sm-%s theme-row-cols-md-%s theme-row-cols-lg-%s theme-row-cols-xl-%s',
    $per_row['sm'],
    $per_row['md'],
    $per_row['lg'],
    $per_row['xl']
);
?>

<div class="site-container archive-post-warp">
    <div class="container">
        <div class="row">
            <div class="<?php echo esc_attr( $class_col_content ); ?>">
                <?php if ( have_posts() ) : ?>
                    <div class="content-archive-post gap-6 <?php echo esc_attr( $per_row_classes ); ?>">
		                <?php while ( have_posts() ) : the_post(); ?>
                            <div class="item d-flex flex-column gap-3">
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="post-thumbnail">
                                        <?php the_post_thumbnail('large'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php basictheme_post_meta(); ?>

                                <div class="post-desc">
                                    <p>
                                        <?php
                                        if (has_excerpt()) :
                                            echo esc_html(get_the_excerpt());
                                        else:
                                            echo wp_trim_words(get_the_content(), 30, '...');
                                        endif;
                                        ?>
                                    </p>

                                    <?php basictheme_link_page(); ?>
                                </div>

                                <div class="read-more flex-fill d-flex align-items-end">
                                    <a href="<?php the_permalink(); ?>" class="text-read-more">
                                        <?php esc_html_e('Đọc tiếp', 'basictheme'); ?>
                                    </a>
                                </div>
                            </div>
		                <?php endwhile; wp_reset_postdata();
		                ?>
                    </div>
                <?php
	                basictheme_pagination();
                else:
	                if ( is_search() ) :
		                get_template_part('template-parts/post/content', 'no-data');
	                endif;
                endif;
                ?>
            </div>

            <?php
            if ( $sidebar !== 'hide' ) :
                get_sidebar();
            endif;
            ?>
        </div>
    </div>
</div>