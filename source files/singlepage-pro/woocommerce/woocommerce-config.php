<?php
/**
 * The config for woocommerce
 *
 * @version    2.0.1
 */
 
if (class_exists( 'woocommerce' )) {
	
	// Disable WooCommerce styles
	//add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	
	global $woocommerce_loop;
	$woocommerce_loop['columns'] = 4;
	
	if( intval(of_get_option('woocommerce-page-num')) > 0){
		// Display 20 products per page. Goes in functions.php
		
		$default_page_num = intval( of_get_option('woocommerce-page-num') );

		if(isset($_GET['woo-per-page-num'])){
			$return_page_num = $default_page_num * (intval($_GET['woo-per-page-num']) + 1);
		}else{
			$return_page_num = $default_page_num;
		}
		
		add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$return_page_num.';' ), 20 );
	}
	
	// Setting shop page image use fancybox lightbox
	if(get_option( 'woocommerce_enable_lightbox' ) == 'yes'){
		update_option( 'woocommerce_enable_lightbox', 'no');
	}
	
	// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
	add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
	 
	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		ob_start();
		get_template_part( 'woocommerce/content', 'topbar-header' );
		$fragments['a.cart-contents'] = ob_get_clean();
		
		ob_start();
		get_template_part( 'woocommerce/content', 'cart-list-btn' );
		$fragments['a.cart-list-btn'] = ob_get_clean();
		
		ob_start();
		get_template_part( 'woocommerce/content', 'cart-list-btn-2' );
		$fragments['a.cart-list-btn-2'] = ob_get_clean();
		
		ob_start();
		get_template_part( 'woocommerce/content', 'cart-list' );
		$fragments['div.cart-list-contents'] = ob_get_clean();
		
		ob_start();
		get_template_part( 'woocommerce/content', 'mini-bar-cart-list' );
		$fragments['div.mini-cart-list-contents'] = ob_get_clean();
		
		return $fragments;
	}
	
	//wishlist
	if( class_exists( 'YITH_WCWL_UI' ) ){
		update_option( 'yith_wcwl_button_position', 'shortcode');
	}
}

function singlepage_get_wishlist($add_wishlist = '', $just_added = '', $view_wishlist = ''){
	
	global $product;
	
	$url = YITH_WCWL()->get_wishlist_url();
	$default_wishlists = is_user_logged_in() ? YITH_WCWL()->get_wishlists( array( 'is_default' => true ) ) : false;

	if( ! empty( $default_wishlists ) ){
		$default_wishlist = $default_wishlists[0]['ID'];
	}
	else{
		$default_wishlist = false;
	}
	$exists = YITH_WCWL()->is_product_in_wishlist( $product->id, $default_wishlist );
	
	$label = '';
	$icon = '';
	
	$classes = get_option( 'yith_wcwl_use_button' ) == 'yes' ? 'class="button product-details add_to_wishlist single_add_to_wishlist button alt"' : 'class="add_to_wishlist button product-details"';
	
	$html  = '<div class="yith-wcwl-add-to-wishlist add-to-wishlist-'.$product->id.'">';
	
	$html .= '<div class="yith-wcwl-add-button';  // the class attribute is closed in the next row
	
	$html .= $exists ? ' hide" style="display:none;"' : ' show"';
	
	$html .= '><a href="' . esc_url( $url ) . '" data-product-id="' . $product->id . '" ' . $classes . ' ><i class="fa fa-star-o"></i>'.$add_wishlist.'<div class="ajax-loading" id="add-items-ajax-loading" style="visibility:hidden"><i class="fa fa-spinner fa-spin"></i></div></a>';
	
	$html .= '</div>';
	
	$html .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a class="button product-details" href="' . esc_url( $url ) . '"><i class="fa fa-star"></i>'.$just_added.'</a></div>';
	
	$html .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a class="button product-details" href="' . esc_url( $url ) . '"><i class="fa fa-star"></i>'.$view_wishlist.'</a></div>';
	$html .= '<div class="yith-wcwl-wishlistaddresponse"></div>';
	$html .= '</div>';
	
	return $html;
}


/* Out of Stock Check */
function singlepage_out_of_stock() {
  global $post;
  $id = $post->ID;
  $status = get_post_meta($id, '_stock_status',true);
  
  if ($status == 'outofstock') {
  	return true;
  } else {
  	return false;
  }
}