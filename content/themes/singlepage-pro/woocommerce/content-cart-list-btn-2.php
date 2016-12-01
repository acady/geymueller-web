<?php
/**
 * The template for displaying header cart style 2
 */
global $woocommerce;
?>
<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="header-cart-btn cart-list-btn-2"><i class="fa fa-shopping-cart"></i> <span class="cart-list-btn-title"><?php _e('My Cart', 'singlepage'); ?></span> <?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'singlepage'), $woocommerce->cart->cart_contents_count);?> </a>