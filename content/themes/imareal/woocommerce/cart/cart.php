<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div style="display: none;">
<?php 
	wc_print_notices();
?>
</div>

<?php 

do_action( 'woocommerce_before_cart' );

?>

<div class="container">
	
	<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
	
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	
	<!--<h1><?php _e( 'Cart', 'woocommerce' ); ?></h1>-->
		<h1 class="cart-header">Übersicht der Bestellung</h1>
	
	<div class="cart-container">
	
		<div class="row cart-heading">
			<div class="product-thumbnail">&nbsp;</div>
			<div class="product-name"><?php //_e( 'Product', 'woocommerce' ); ?></div>
			<div class="product-variationattribute">&nbsp;</div>
			<!--
			<div class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></div>
			<div class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></div>
			<div class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></div>
			-->
			<div class="product-remove">&nbsp;</div>
		</div>
	
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>
	
			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
	
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<div class="row cart-entry">
						
						<div class="product-thumbnail">
							<?php
								
								$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id($_product->post->ID), 'shop_thumbnail' );
								
								echo '<div class="cart-image"><img src="'. $thumbnail_src[0] .'" class="img-responsive" /></div>';
								
								set_query_var('_product', $_product);
								set_query_var('_product_id', $_product_id);
								set_query_var('cart_item_key', $cart_item_key);
								get_template_part( 'partials/removeproduct' );
							?>
						</div>
	
						<div class="product-name">
							<?php
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
	
								// Meta data
								echo WC()->cart->get_item_data( $cart_item );
	
								// Backorder notification
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
								}
							?>
						</div>
						
						<div class="product-variationattribute">

							<?php
								set_query_var('product', $_product);
								get_template_part( 'partials/variationattribute' );
								// $download['product_id'];

								$archivnr_values = get_the_terms( $_product->id, 'pa_archivnummer');
								foreach ( $archivnr_values as $versionvalue ) {
									echo $versionvalue->name.'<br>';
								}

								$bildthema_values = get_the_terms( $_product->id, 'pa_bildthema');
								foreach ( $bildthema_values as $bildthema_value ) {
									echo $bildthema_value->name.'<br>';
								}

								$fotonummer_values = get_the_terms( $_product->id, 'pa_fotonummer');
								foreach ( $fotonummer_values as $fotonummer_value ) {
									echo $fotonummer_value->name.'<br>';
								}

								$institution_values = get_the_terms( $_product->id, 'pa_institution');
								foreach ( $institution_values as $institution_value ) {
									echo $institution_value->name.'<br>';
								}
								/*
								 * Inventarnummer gibt es noch nicht.
								$inventarnummer_values = get_the_terms( $_product->id, 'pa_inventarnummer');
								foreach ( $inventarnummer_values as $inventarnummer_value ) {
									echo $inventarnummer_value->name.'<br>';
								}
								*/
								$standort_values = get_the_terms( $_product->id, 'pa_standort');
								foreach ( $standort_values as $standort_value ) {
									echo $standort_value->name.'<br>';
								}

							?>
							
						</div>
						<!--
						<div class="product-price">
							<div class="price-label"><?php _e( 'Price', 'woocommerce' ); ?>:</div>
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</div>
	
						<div class="product-quantity">
							<div class="quantity-label"><?php _e( 'Quantity', 'woocommerce' ); ?>:</div>
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
										'min_value'   => '0'
									), $_product, false );
								}
	
								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
							?>
							
						</div>
	
						<div class="product-subtotal">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</div>
						-->
						<div class="product-remove">
							<?php
								set_query_var('_product', $_product);
								set_query_var('_product_id', $_product_id);
								set_query_var('cart_item_key', $cart_item_key);
								get_template_part( 'partials/removeproduct' );
							?>
						</div>
						
						<div class="product-separator">
							<div class="product-separator-inner">
							</div>
						</div>
						
					</div>
					<?php
				}
			} ?>
		<!--
		<div class="row">
			<div class="col-sm-offset-8 col-sm-4 update-cart-container">
				<input type="submit" class="update-cart-button" name="update_cart" value="<?php esc_attr_e( 'Update', 'woocommerce' ); ?>"/>
			</div>
		</div>
			-->
	</div>
			
	<?php
	do_action( 'woocommerce_cart_contents' );
	?>
	<div class="row">
		<div class="col-sm-offset-3 col-sm-6 actions">
			
			<?php if ( WC()->cart->coupons_enabled() ) { ?>
				<div class="coupon">

					<label for="coupon_code"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>" />

					<?php do_action( 'woocommerce_cart_coupon' ); ?>
				</div>
			<?php } ?>

			<?php do_action( 'woocommerce_cart_actions' ); ?>

			<?php wp_nonce_field( 'woocommerce-cart' ); ?>
		</div>
	</div>
	
	<?php do_action( 'woocommerce_after_cart_contents' ); ?>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>
	
	</form>

</div>

<div class="cart-collaterals cart-after-cart">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>
<div class="cart-after-cart">
<?php do_action( 'woocommerce_after_cart' ); ?>
</div>