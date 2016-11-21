<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div style="display: none;">
<?php
wc_print_notices();
?>
</div>

<?php
do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<div class="container">
	
	<!--<h1><?php //_e( 'Checkout', 'woocommerce' ); ?></h1>-->
	<h1 class="cart-header">Daten zur Bestellung</h1>
	
	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">
		<div class="col-sm-offset-2 col-sm-10 checkout-form">
			<?php do_action('checkout_praeambel'); ?>
		</div>
		<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
	
			<div class="col2-set col-sm-10" id="customer_details">
				<div class="col-1 border-bottom">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
				</div>
				<div class="col-2">
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>

			</div>
	
			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
	
		<?php endif; ?>
	
	<div class="row">
		
		<div class="col-sm-offset-2 col-sm-10 checkout-form">
			
			<div class="checkout-heading"><h3 class="checkout-heading">Ausgewählte Fotos in der Bestellung</h3><?php //_e( 'Your order', 'woocommerce' ); ?></div>
			
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
			
			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>
			
			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			
		</div>
	
	</div>
	
	</form>

</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
