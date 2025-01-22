<?php
$opt_number_columns = basictheme_get_option('opt_footer_columns', '4');

if( is_active_sidebar( 'sidebar-footer-column-1' ) || is_active_sidebar( 'sidebar-footer-column-2' ) || is_active_sidebar( 'sidebar-footer-column-3' ) || is_active_sidebar( 'sidebar-footer-column-4' ) ) :

?>
    <div class="global-footer__column">
        <div class="container">
            <div class="row row-gap-6">
	            <?php
	            for( $i = 0; $i < $opt_number_columns; $i++ ):
		            $j = $i +1;
		            $cols = basictheme_get_option( 'opt_footer_column_width_' .  $j, 3);

		            if( is_active_sidebar( 'sidebar-footer-column-'.$j ) ):
			            ?>
                        <div class="col-12 col-sm-<?php echo esc_attr( $cols['sm'] ); ?> col-md-<?php echo esc_attr( $cols['md'] ); ?> col-lg-<?php echo esc_attr( $cols['lg'] ); ?> col-xl-<?php echo esc_attr( $cols['xl'] ); ?>">
				            <?php dynamic_sidebar( 'sidebar-footer-column-'.$j ); ?>
                        </div>
		            <?php
		            endif;
	            endfor;
	            ?>
            </div>
        </div>
    </div>
<?php endif; ?>