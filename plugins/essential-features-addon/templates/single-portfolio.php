<?php get_header(); ?>

<div class="warp pt-6 pb-6">
    <div class="container">
        <?php
        if ( have_posts() ) :
            while (have_posts()) :
                the_post();
        ?>
            <div id="cpt-portfolio-<?php the_ID(); ?>" class="cpt-portfolio-detail">
                <?php if ( has_post_thumbnail() ) :?>
                    <div class="image-box mb-3">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>

                <h1 class="title">
                    <?php the_title(); ?>
                </h1>

                <div class="content-box">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php
            endwhile;
        endif;
        ?>
    </div>
</div>

<?php
get_footer();