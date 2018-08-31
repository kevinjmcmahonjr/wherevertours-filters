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
function hide_travelers_admin_bar( $show ){
	if ( ! current_user_can( 'edit_posts' )){
		$show = false;
	}
	return $show;
}
add_filter( 'show_admin_bar' , 'hide_travelers_admin_bar' , 20 , 1 );

/** Disable All WooCommerce  Styles and Scripts Except Shop Pages*/
function dequeue_woocommerce_styles_scripts() {
	if ( function_exists( 'is_woocommerce' ) ) {
		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
		# Styles
		wp_dequeue_style( 'woocommerce-general' );
		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_dequeue_style( 'woocommerce_frontend_styles' );
		wp_dequeue_style( 'woocommerce_fancybox_styles' );
		wp_dequeue_style( 'woocommerce_chosen_styles' );
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		# Scripts
		wp_dequeue_script( 'wc_price_slider' );
		wp_dequeue_script( 'wc-single-product' );
		wp_dequeue_script( 'wc-add-to-cart' );
		wp_dequeue_script( 'wc-cart-fragments' );
		wp_dequeue_script( 'wc-checkout' );
		wp_dequeue_script( 'wc-add-to-cart-variation' );
		wp_dequeue_script( 'wc-single-product' );
		wp_dequeue_script( 'wc-cart' );
		wp_dequeue_script( 'wc-chosen' );
		wp_dequeue_script( 'woocommerce' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_styles_scripts', 99 );

function account_creation_referral_url( $form ){
	// Grab URL from HTTP Server Var and put it into a variable
	$referral_url = $_SERVER['HTTP_REFERER'];
	// Return that value to the form
	return esc_url_raw($referral_url);
}
add_filter( 'gform_field_value_referral_url', 'account_creation_referral_url');
	
function account_activation_redirect_add_referral( ){
	$current_user = wp_get_current_user();
	$current_user_email = $current_user->user_email;
	
	$search_criteria['field_filters'][] = array( 'key' => '5', 'value' => $current_user_email);
	$entries = GFAPI::get_entries( '2', $search_criteria );
	
	$return_to_referral_url = rgar( $entries[0], '5' );
	$base_activation_redirect_url = 'https://wherevertours.com/account-activation-successful/';
	$activation_redirect_url = $base_activation_redirect_url . '?returntoreferralurl=' . $return_to_referral_url;
	return $activation_redirect_url;
}
add_filter( 'gpbua_activation_redirect_url', 'account_activation_redirect_add_referral' );

function output_current_user_email(){
	$current_user = wp_get_current_user();
	$current_user_email = $current_user->user_email;
	echo $current_user_email;
	
	$search_criteria['field_filters'][] = array( 'key' => '5', 'value' => $current_user_email);
	$entries = GFAPI::get_entries( '2', $search_criteria );
	echo '<pre>', var_dump ($entries), '</pre>';
}
add_shortcode( 'display_current_user_email', 'output_current_user_email')

// Rename Registration
/*function tml_action_template_message_filter( $message, $action ) {
    if ( 'register' == $action )
        return 'Create Account';
    return $message;
}
add_filter( 'tml_action_template_message', 'tml_action_template_message_filter', 10, 2 );
*/
?>
