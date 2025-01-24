<?php get_header(); ?>

    <div class="warp pt-6 pb-6">
        <div class="container">
			<?php if ( have_posts() ) : ?>
                <div class="row row-cols-3 row-gap-6">
					<?php while ( have_posts() ) : the_post(); ?>
                        <div class="col">
                            <div id="cpt-portfolio-<?php the_ID(); ?>" class="cpt-item">
                                <h2 class="title">
									<?php the_title(); ?>
                                </h2>

								<?php if ( has_post_thumbnail() ) : ?>
                                    <div class="image-box mb-3">
										<?php the_post_thumbnail( 'medium_large' ); ?>
                                    </div>
								<?php endif; ?>

                                <div class="desc">
                                    <p>
										<?php
										if ( has_excerpt() ) :
											echo esc_html( get_the_excerpt() );
										else:
											echo wp_trim_words( get_the_content(), 30, '...' );
										endif;
										?>
                                    </p>

                                    <a href="<?php the_permalink(); ?>" class="text-read-more">
										<?php esc_html_e( 'Xem thêm ', 'essential-features-addon' ); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
					<?php
					endwhile;
					wp_reset_postdata();
					?>
                </div>
			<?php
				efa_pagination();
            else :
            ?>
                <p><?php esc_html_e( 'Không có bài viết nào', 'essential-features-addon' ); ?></p>
			<?php endif; ?>
        </div>
    </div>

<?php
get_footer();
