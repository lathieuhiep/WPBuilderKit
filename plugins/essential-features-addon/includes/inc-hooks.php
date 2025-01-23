<?php
function efa_modify_queries_for_ctp( $query ): void {
	if ( $query->is_main_query() && ! is_admin() ) {
		if ( $query->is_post_type_archive( 'portfolio' ) || $query->is_tax( [ 'portfolio_cat', 'portfolio_tag' ] ) ) {
			$query->set( 'posts_per_page', 10 );
		}

		if ( $query->is_search() && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'portfolio' ) {
			$query->set('post_type', 'portfolio');
		}
	}
}

add_action( 'pre_get_posts', 'efa_modify_queries_for_ctp' );