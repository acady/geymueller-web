<?php
/**
 * The template for displaying header cart
 */
global $woocommerce;
?>
<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="header-cart-btn cart-list-btn"><i class="fa fa-shopping-cart"></i> <?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'singlepage'), $woocommerce->cart->cart_contents_count);?></a>