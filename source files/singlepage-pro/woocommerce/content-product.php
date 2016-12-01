<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>
<li <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	
		<a href="<?php the_permalink(); ?>" class="product-thumbs-img">
		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			 
			if (is_object($product)){

				 if ( has_post_thumbnail() ) {
					 echo '<span class="front">'.get_the_post_thumbnail(get_the_ID(), "shop_catalog" , array('alt' => get_the_title())).'</span>';
					 $attachment_ids = $product->get_gallery_attachment_ids();
					 if($attachment_ids && count($attachment_ids) > 0){
						$attachments = wp_get_attachment_image_src( $attachment_ids[0] , 'shop_single');
						
						  if(isset($attachments[0])){
							  echo '<span class="back"><img src="'.esc_url($attachments[0]).'" alt="" ></span>';
						 }
					 }
				 }

				if($product->is_featured()){
					echo apply_filters('woocommerce_sale_flash', '<span class="featured">'.__('Featured','singlepage').'</span>', $post, $product);
				}else if($product->is_on_sale()){
					 echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__( 'Sale!', 'singlepage' ).'</span>', $post, $product);
				}else if(!$product->is_in_stock()){
					 echo '<span class="outofstock">'.__('Out of Stock','singlepage').'</span>';
				}else  if(!$product->get_price()){
					 echo '<span class="free">'.__('Free','singlepage').'</span>';
				}				 
			}
		?>
        </a>
        <div class="product-meta">
		<a href="<?php the_permalink(); ?>" class="product-title"><h3><?php the_title(); ?></h3></a>
		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			
			if( class_exists( 'YITH_WCWL_UI' ) ){
				echo singlepage_get_wishlist();
			}else{
				echo '<a href="'.get_permalink().'" class="button product-details"><i class="fa fa fa-list"></i></a>';
			}
		?>
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		</div>
</li>