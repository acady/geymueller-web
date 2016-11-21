<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>

<p class="cart-empty"><b>Sie haben noch keine Bilder in Ihrer Bestellung.</b><?php //_e( 'Your cart is currently empty.', 'woocommerce' ) ?></p>
<div class="text-center">
	<p>Mit diesem Icon können Sie Bilder ihrer Bestellung hinzu fügen:</p>
<!--<img src="../images/add_to_cart.png" alt="add to cart symbol" />-->
	<br>
	<i class="upscale icon-Realienkunde-_Fotobestellung" ng-hide="addToCartLoading"></i>
	<br><br>
	<p>Sie finden es rechts oben in der Detailansicht eines Werkes in den Suchergebnissen.</p>
</div>
<br><br>
<?php do_action( 'woocommerce_cart_is_empty' ); ?>

<div class="text-center">
	<a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
		Zur&uuml;ck zur Suche
	</a>
</div>