<?php

use ExtendSite\Options\HeaderOptions;

$sticky_menu = basictheme_opt(HeaderOptions::class)?->get_position_fixed_menu() ?? true;
?>
<header class="main-header <?php echo esc_attr( $sticky_menu ? 'active-sticky-nav' : '' ); ?>">
    <nav class="main-header__warp container">
        <!-- main logo -->
        <?php get_template_part('components/header/logo'); ?>

        <!-- Main menu -->
        <?php get_template_part('components/header/nav'); ?>

        <!-- Main shopping cart -->
        <?php get_template_part('components/header/inc', 'shopping-cart'); ?>
    </nav>
</header>