<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_the_title(); // needs to be here

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'woocommerce' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				_e( 'Please attempt your purchase again or go to your account page.', 'woocommerce' );
			else
				_e( 'Please attempt your purchase again.', 'woocommerce' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>
	
	<h1><?php echo get_field('heading'); ?></h1>
	
	<div class="container">
		
		<div class="row">
		
			<div class="col-sm-offset-1 col-sm-10">
				
				<div class="thankyou-description">
					<?php echo get_field('description'); ?>
				</div>
			</div>
		
		</div>
		
		<div class="checkout-heading">
			<!--<?php _e( 'Your order', 'woocommerce' ); ?>-->
			<h3 class="checkout-heading">Ihre Bestellung wird bearbeitet, vielen Dank!</h3>
		</div>
		
		<div class="row">
		
			<div class="col-sm-offset-4 col-sm-4">
				
				<div class="thankyou-order-info">
					<table class="table borderless">
						<tr class="order">
							<th><?php _e( 'Order Number:', 'woocommerce' ); ?></th>
							<td><?php echo $order->get_order_number(); ?></td>
						</tr>
						<tr class="date">
							<th><?php _e( 'Date:', 'woocommerce' ); ?></th>
							<td><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></td>
						</tr>
						<!--
						<tr class="total">
							<th><?php _e( 'Total:', 'woocommerce' ); ?></th>
							<td><?php echo $order->get_formatted_order_total(); ?></td>
						</tr>
						-->
					</table>
				</div>
				
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12 text-left">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="back-to-shop">
					<?php //_e( 'Return To Shop', 'woocommerce' ); ?>Zurück zur Fotobestellung
				</a>
			</div>
			
		</div>
		
	</div>
	
	<?php endif; ?>

<?php else : ?>

	<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

<?php endif; ?>
