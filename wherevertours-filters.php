<?php
/*
Plugin Name: Wherever Tours Filters
Plugin URI:
Description: General Filters and Actions to adjust names and phrases through-out WordPress
Version: 1.0
Author: Kevin J. McMahon Jr.
Author URI:
License:GPLv2
*/
?>
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Hide Admin Bar
function hide_travelers_admin_bar(){
	if (!current_user_can('edit_posts'){
		show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'hide_travelers_admin_bar');

// Rename Registration
function tml_action_template_message_filter( $message, $action ) {
    if ( 'register' == $action )
        return 'Create Account';
    return $message;
}
add_filter( 'tml_action_template_message', 'tml_action_template_message_filter', 10, 2 );
?>