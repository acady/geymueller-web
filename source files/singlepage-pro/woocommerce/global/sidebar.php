<?php
/**
 * Sidebar
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(is_single()){
	$sidebar_name = get_post_meta(get_the_ID(), 'sidebar-type', true);
}else{
	$shop_page_id = woocommerce_get_page_id( 'shop' );
	$sidebar_name = get_post_meta($shop_page_id , 'sidebar-type', true);
}
if($sidebar_name == "Global Sidebar" || $sidebar_name == ""){
	dynamic_sidebar('shop');
}else{
	dynamic_sidebar($sidebar_name);
}