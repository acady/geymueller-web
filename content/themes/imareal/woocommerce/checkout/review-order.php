<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

	if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		?>
		<div class="mobile-checkout-review-product-row">
			<div class="left-column">
				<div>
					<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
					<?php echo WC()->cart->get_item_data( $cart_item ); ?>
				</div>
				<div>
					<?php
						set_query_var('product', $_product);
						get_template_part( 'partials/variationattribute' );
					?>
				</div>
			</div>
			<div class="right-column">
				<div><?php _e( 'Quantity', 'woocommerce' ); ?>:&nbsp;<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', $cart_item['quantity'], $cart_item, $cart_item_key ); ?></div>
				<div><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></div>
			</div>
		</div>
		<?php
	}
}
?>
<table class="shop_table woocommerce-checkout-review-order-table table borderless">
	<thead>
		<tr>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-variationattribute"></th>
			<!--
			<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
			-->
		</tr>
	</thead>
	<tbody>
		<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						<td class="product-name">
							<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
							<?php echo WC()->cart->get_item_data( $cart_item ); ?>
						</td>
						<td class="product-variationattribute">
							<?php
								set_query_var('product', $_product);
								get_template_part( 'partials/variationattribute' );
							?>
						</td>
						<!--
						<td class="product-quantity">
							<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', $cart_item['quantity'], $cart_item, $cart_item_key ); ?>
						</td>
						<td class="product-total">
							<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
						</td>
						-->
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>
		<!--
		<tr class="cart-subtotal">
			<th class="cart-totals-heading" colspan="3"><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
			<td class="cart-totals-value"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>
-->
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php
				//wc_cart_totals_shipping_html();
			?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
<!--
		<tr class="order-total">
			<th class="cart-totals-heading"  colspan="3"><?php _e( 'Total', 'woocommerce' ); ?></th>
			<td class="cart-totals-value"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>
-->
		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>