<?php $basictheme_unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="search" id="<?php echo $basictheme_unique_id; ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Tìm kiếm...', 'placeholder', 'basictheme' ); ?>" value="<?php echo get_search_query(); ?>" name="s" aria-label="" />

    <button type="submit" class="btn search-submit">
        <i class="fas fa-search"></i>
    </button>
</form>