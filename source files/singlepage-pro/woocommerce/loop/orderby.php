<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $wp_query;

if ( 1 == $wp_query->found_posts || ! woocommerce_products_will_display() )
	return;
?>
<div class="woocommerce-ordering-filter">
<form class="woocommerce-ordering" method="get">
	<ul class="orderby-list mline">
    	<li>
		<?php
			$catalog_orderby = apply_filters( 'woocommerce_catalog_orderby', array(
				'menu_order' => __( 'Default sorting', 'singlepage' ),
				'popularity' => __( 'Sort by popularity', 'singlepage' ),
				'rating'     => __( 'Sort by average rating', 'singlepage' ),
				'date'       => __( 'Sort by newness', 'singlepage' ),
				'price'      => __( 'Sort by price: low to high', 'singlepage' ),
				'price-desc' => __( 'Sort by price: high to low', 'singlepage' )
			) );

			if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' ){
				unset( $catalog_orderby['rating'] );
			}
			if(!isset($orderby) || !($orderby == "popularity" || $orderby == "rating" || $orderby == "date" || $orderby == "price" || $orderby == "price-desc")){
				$orderby = 'menu_order';
			}
			
			$child_ul = '<ul>';
			$default_name = '';
			foreach ( $catalog_orderby as $id => $name ){
				if(selected( $orderby, $id, false )){
					echo '<div class="list-name">'.esc_attr( $name ).'<span class="arrow"><i class="fa fa-angle-down"></i></span></div>';
				}
				$child_ul .= '<li data-value="' . esc_attr( $id ) . '" class="'.(selected( $orderby, $id, false ) ? "select" : "").'"><div class="list-name">' . esc_attr( $name ) . '<span class="arrow"><i class="fa fa-check"></i></span></div></li>';
			}
			$child_ul .= '</ul>';
			echo $child_ul;
		?>
        </li>
	</ul>
    <input class="orderby-name" type="hidden" name="orderby" value="<?php esc_attr($orderby); ?>" />
	<?php
		// Keep query string vars intact
		foreach ( $_GET as $key => $val ) {
			if ( 'orderby' == $key )
				continue;
			
			if (is_array($val)) {
				foreach($val as $innerVal) {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
				}
			
			} else {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
			}
		}
	?>
</form>

    <div class="woocommerce-ordering-listorder">
        <a class="listorder-price <?php 
            if($orderby == "price"){ 
                echo "select up";
            }else if($orderby == "price-desc"){
                echo "select down";
            }
         ;?>"><span><i class="fa fa-arrow-up"></i><i class="fa fa-arrow-down"></i></span> <?php _e( 'Price', 'singlepage' );?></a>
        <a class="listorder-popularity <?php 
            if($orderby == "popularity"){ 
                echo "select";
            }
         ;?>"><?php _e( 'Popularity', 'singlepage' );?></a>
        <a class="listorder-rate <?php 
            if($orderby == "rating"){ 
                echo "select";
            }
         ;?>"><?php _e( 'Rating', 'singlepage' );?></a>
    </div>
    <div class="orderby-list-page-number">
		 <?php 
			$default_page_num = intval( of_get_option('woocommerce-page-num',12) );
			$get_page_num_index = $default_page_num;
			
			if(isset($_GET['woo-per-page-num'])){
				$get_page_num_index = intval($_GET['woo-per-page-num']);
			}

			$page_arr = array(
							  $default_page_num =>__('Show ','singlepage').$default_page_num.__(' Products', 'singlepage'), 
							 intval($default_page_num * 2) => __('Show ','singlepage').intval($default_page_num * 2).__(' Products', 'singlepage'), 
							 intval($default_page_num * 3) => __('Show ','singlepage').intval($default_page_num * 3).__(' Products', 'singlepage'),
							  intval($default_page_num * 4) =>__('Show ','singlepage').intval($default_page_num * 4).__(' Products', 'singlepage')
							  );
	
		?>
        <ul class="orderby-list mline">
            <li>
                <div class="list-name"><?php echo isset($page_arr[$get_page_num_index])?$page_arr[$get_page_num_index]:$page_arr[$default_page_num]; ?><span class="arrow"><i class="fa fa-angle-down"></i></span></div>
                <ul>
                	<?php 
						
						foreach($page_arr as $key => $value){
							echo ' <li data-value="'.$key.'" '.( $key == $get_page_num_index ? 'class="select"' : '').' ><div class="list-name">'.$page_arr[$key].'<span class="arrow"><i class="fa fa-check"></i></span></div></li>';
							
						}
					
					?>
                   
                </ul>
            </li>
        </ul>
    </div>
</div>
