<?php
/**
 * Output a single payment method
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$isCreditCard = $gateway->id == 's4wc';
$isPaypal = $gateway->id == 'paypal';

?>
<li class="payment_method_<?php echo $gateway->id; ?>">
	<input id="payment_method_<?php echo $gateway->id; ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

	<label for="payment_method_<?php echo $gateway->id; ?>">
		<div class="payment-method-name">
		<?php
			if($isCreditCard) {
				_e( 'Credit card', 'woocommerce' );
			} else {
				echo $gateway->get_title();
			}
		?>
		</div>
		<?php
			if($isPaypal) {
		?>
			<img src="<?php echo get_template_directory_uri() ?>/images/payment/paypal.png" style="height: 21px;" />
		<?php
			} else {
		?>
			<img src="<?php echo get_template_directory_uri() ?>/images/payment/visa.png" alt="Visa" style="width:40px;" />
			<img src="<?php echo get_template_directory_uri() ?>/images/payment/mastercard.png" alt="MasterCard" style="width:40px;" />
			<img src="<?php echo get_template_directory_uri() ?>/images/payment/amex.png" alt="American Express" style="width:40px;" />
		<?php
			}
		?>
	</label>
	<?php
		if ( !$isPaypal && ( $gateway->has_fields() || $gateway->get_description() ) ) : ?>
		<div class="payment_box payment_method_<?php echo $gateway->id; ?>" <?php if ( ! $gateway->chosen ) : ?>style="display:none;"<?php endif; ?>>
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>
</li>
