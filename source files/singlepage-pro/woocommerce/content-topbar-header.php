<?php
/**
 * The template for displaying header top bar menu
 */
global $woocommerce;
?>
<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'singlepage'); ?>"><i class="fa fa-shopping-cart"></i><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'singlepage'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>