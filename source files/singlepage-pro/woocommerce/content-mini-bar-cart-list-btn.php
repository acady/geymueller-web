<?php
/**
 * The template for displaying header cart
 */
global $woocommerce;
?>
<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i></a>