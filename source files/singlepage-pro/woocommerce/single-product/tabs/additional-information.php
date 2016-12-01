<?php
/**
 * Additional Information tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post, $product;

$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional Information', 'singlepage' ) );
?>
<div class="mx-title">
	<h4 class="post-title"><?php echo $heading; ?></h4>
</div>

<?php $product->list_attributes(); ?>