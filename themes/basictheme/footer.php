    </div><!--End Sticky Footer-->

    <?php
    if ( !is_404() ) :
        get_template_part('components/footer/inc', 'layout');
     endif;
     ?>
</div><!-- .main-warp -->

<?php
get_template_part('components/inc', 'loading');
get_template_part('components/inc', 'back-top');

wp_footer();
?>

</body>
</html>
