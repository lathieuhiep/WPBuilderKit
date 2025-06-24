<?php
$opt_back_to_top = basictheme_get_option( 'opt_general_back_to_top', '1' );

if ( $opt_back_to_top != '1' ) return;
?>

<div id="back-top">
    <a href="#">
        <i class="fas fa-chevron-up"></i>
    </a>
</div>