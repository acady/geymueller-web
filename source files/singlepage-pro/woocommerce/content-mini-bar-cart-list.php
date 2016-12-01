<?php
/**
 * The template for displaying header cart
 */
global $woocommerce;
?>

<?php if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) { ?>
<div class="mini-cart-list-contents">
	<p class="total"><strong><?php _e( 'Subtotal', 'singlepage' ); ?>:</strong> <?php echo $woocommerce->cart->get_cart_subtotal(); ?></p>
    <ul class="mline">
    <?php foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product = $cart_item['data'];
    
                // Only display if allowed
                if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 ){
                    continue;
                }
                // Get price
                $product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
    
                $product_price = apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $cart_item, $cart_item_key );
        ?>
    <li>
        <a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
                <?php echo $_product->get_image(); ?>
        </a>
        <div class="cart-list_product-content">
            <div class="cart-list_product-name">
                <a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
                <?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ); ?>
                </a>
            </div>
            
            <div class="cart-list_product-data">
            <?php echo $woocommerce->cart->get_item_data( $cart_item ); ?>
            </div>
        </div>
        
        <div class="cart-list_product-quantity">
            <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
        </div>
    </li>
    
    <?php } ?>
    </ul><!-- end product list -->
    <p>
        <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="btn btn-theme"><?php _e( 'View Cart &rarr;', 'singlepage' ); ?></a>
        <a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>" class="btn btn-theme checkout"><?php _e( 'Checkout &rarr;', 'singlepage' ); ?></a>
    </p>
<?php }else { ?>
<div class="mini-cart-list-contents empty">
    <p><?php _e( 'No products in the cart.', 'singlepage' ); ?></p>
    <p><a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>" class="btn btn-theme checkout"><?php _e( 'Go Shop', 'singlepage' ); ?></a></p>
<?php } ?>
</div>