<div class="container">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="site-page-content">
            <?php
            the_content();
            basictheme_link_page();
            ?>
        </div>
    <?php
	    get_template_part( 'template-parts/parts/comment','form' );
    endwhile;
    ?>
</div>