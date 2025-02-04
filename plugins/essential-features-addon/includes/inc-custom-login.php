<?php
function efa_enqueue_custom_login_style(): void {
	wp_enqueue_style('efa-custom-login', EFA_PLUGIN_URL . 'assets/css/efa-custom-login.min.css');
}
add_action('login_enqueue_scripts', 'efa_enqueue_custom_login_style');