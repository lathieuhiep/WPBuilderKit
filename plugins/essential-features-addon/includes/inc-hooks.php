<?php
add_action( 'pre_get_posts', 'efa_custom_search_query' );
function efa_custom_search_query( $query ): void {
	if ( $query->is_search() && $query->is_main_query() ) {
		if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'portfolio' ) {
			$query->set( 'post_type', $_GET['post_type'] );
		}
	}
}