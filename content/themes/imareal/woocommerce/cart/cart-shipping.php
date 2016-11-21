<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<tr class="shipping">
	<th class="cart-totals-heading" colspan="3">
	<?php
		$method = current( $available_methods );
		echo _e( 'Shipping', 'woocommerce' ) . ': ' . $method->label;
	?>
	</th>
	<td class="cart-totals-value">
	<?php
		echo ltrim(wp_kses_post( wc_cart_totals_shipping_method_label( $method ) ), $method->label . ': ');
	?>
		<input type="hidden" name="shipping_method[<?php echo $index; ?>]" data-index="<?php echo $index; ?>" id="shipping_method_<?php echo $index; ?>" value="<?php echo esc_attr( $method->id ); ?>" class="shipping_method" />
	</td>
</tr>
