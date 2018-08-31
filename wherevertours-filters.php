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
	// Set a cookie
	if(!isset($_COOKIE[$wt_account_activation_referral_url])){
		setcookie( 'wt_account_activation_referral_url', $referral_url, 30 * DAYS_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
	}
	// Return that value to the form
	return esc_url_raw($referral_url);
}
add_filter( 'gform_field_value_referral_url', 'account_creation_referral_url');
	
function account_activation_redirect_add_referral( ){
	$base_activation_redirect_url = 'https://wherevertours.com/account-activation-successful/';
	if(isset($_COOKIE[$wt_account_activation_referral_url])){
		$return_to_referral_url = $_COOKIE[$wt_account_activation_referral_url];
	}
	$activation_redirect_url = $base_activation_redirect_url . '?returntoreferralurl=' . $return_to_referral_url;
	return $activation_redirect_url;
}
add_filter( 'gpbua_activation_redirect_url', 'account_activation_redirect_add_referral' );

// Rename Registration
/*function tml_action_template_message_filter( $message, $action ) {
    if ( 'register' == $action )
        return 'Create Account';
    return $message;
}
add_filter( 'tml_action_template_message', 'tml_action_template_message_filter', 10, 2 );
*/
?>
