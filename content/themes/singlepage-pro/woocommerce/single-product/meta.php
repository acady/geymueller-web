<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

if( class_exists( 'YITH_WCWL_UI' ) ){
	echo singlepage_get_wishlist(__('Add to Wishlist','singlepage'),__('Had added, view Wishlist','singlepage'), __('Already added, view Wishlist','singlepage'));
}

?>


<div class="product_meta">
	
	<?php do_action( 'woocommerce_product_meta_start' ); ?>
	
     <?php if ( get_option( 'woocommerce_enable_review_rating' ) != 'no' ) { ?>
		<?php if ( $rating_html = $product->get_rating_html() ) : ?>
            <span class="product_rate_meta"><?php _e('Rating:','singlepage'); ?><span class="product_rate_star"><?php echo $rating_html; ?></span></span>
        <?php endif; ?>
    <?php } ?>
    
	<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && $product->get_sku() ) : ?>
		<span itemprop="productID" class="sku_wrapper"><?php _e( 'SKU:', 'singlepage' ); ?> <span class="sku"><?php echo $product->get_sku(); ?></span>.</span>
	<?php endif; ?>
	
	<?php
		$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
		echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $size, 'singlepage' ) . ' ', '</span>' );
	?>

	<?php
		$size = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
		echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $size, 'singlepage' ) . ' ', '</span>' );
	?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>

<?php 
if(of_get_option('woocommerce-share-enable') == "on"){ ?> 
	<div class="woocommerce-share">
	<?php if(intval(of_get_option('woocommerce-share-type')) == 0) {
		echo do_shortcode('[share link="'.esc_url( get_permalink() ).'" title="'.esc_attr( get_the_title() ).'"]');
	 } else { ?>
	<?php echo  of_get_option('woocommerce-share-content'); ?>
	<?php } ?>
	</div>
<?php } ?>