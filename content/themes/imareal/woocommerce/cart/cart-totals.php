<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="container <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">
<!--
	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<div class="row">
		
		<div class="col-sm-offset-8 col-sm-4">
			
			<table class="table borderless cart_totals">
			<tbody>
			<tr class="cart-subtotal">
				<th class="cart-totals-heading" colspan="3"><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
				<td class="cart-totals-value"><?php wc_cart_totals_subtotal_html(); ?></td>
			</tr>
		
			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
		
				<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
				
				<?php wc_cart_totals_shipping_html(); ?>
				
				<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
		
			<?php endif; ?>
		
			<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>
		
			<tr class="order-total">
				<th class="cart-totals-heading" colspan="3"><?php _e( 'Total', 'woocommerce' ); ?></th>
				<td class="cart-totals-value"><?php wc_cart_totals_order_total_html(); ?></td>
			</tr>
			</tbody>
			</table>
			
			<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
			
		</div>
	</div>
-->
	<div class="row">
		
		<div class="col-sm-6 col-sm-push-6 text-right">
			<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
		</div>
		
		<div class="col-sm-6 col-sm-pull-6">
			<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="back-to-shop">
				Zur&uuml;ck zur Suche
			</a>
		</div>
	
		<?php do_action( 'woocommerce_after_cart_totals' ); ?>
		
	</div>

</div>
