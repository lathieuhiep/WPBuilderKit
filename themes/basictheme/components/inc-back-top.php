<?php

use ExtendSite\Options\GeneralOptions;

$opt_back_to_top = basictheme_opt(GeneralOptions::class)->get_back_to_top_enabled() ?? true;

if ( $opt_back_to_top ) :
?>

<div id="back-top">
    <a href="#">
        <i class="ic-mask ic-mask-chevron-up"></i>
    </a>
</div>

<?php
endif;