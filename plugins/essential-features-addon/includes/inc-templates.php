<?php
/**
 * Get template with fallback.
 *
 * @param string $template_name The name of the template file.
 *
 * @return string The path to the template.
 */
function efa_get_template_custom( string $template_name ): string {
	// Check if template exists in theme.
	$theme_template = locate_template( 'efa-templates/' . $template_name );

	if ( $theme_template ) {
		return $theme_template;
	}

	// Fallback to plugin template.
	return EFA_PLUGIN_PATH . 'templates/' . $template_name;
}

// load template portfolio
add_filter( 'template_include', 'efa_load_portfolio_templates' );
function efa_load_portfolio_templates( $template ) {
	if ( is_singular( 'portfolio' ) ) {
		return efa_get_template_custom( 'single-portfolio.php' );
	} elseif ( is_post_type_archive( 'portfolio' ) && !is_search() ) {
		return efa_get_template_custom( 'archive-portfolio.php' );
	} elseif ( is_tax( 'portfolio_cat' ) ) {
		return efa_get_template_custom( 'archive-portfolio.php' );
	} elseif ( is_tax( 'portfolio_tag' ) ) {
		return efa_get_template_custom( 'archive-portfolio.php' );
	} elseif ( is_search() && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'portfolio' ) {
		return efa_get_template_custom( 'search-portfolio.php' );
	}

	return $template;
}
