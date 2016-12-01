<?php
/**
 * The template for displaying mini bar
 */
global $wpdb, $yith_wcwl, $woocommerce;

if( isset( $_GET['user_id'] ) && !empty( $_GET['user_id'] ) ) {
    $user_id = $_GET['user_id'];
} elseif( is_user_logged_in() ) {
    $user_id = get_current_user_id();
}

$current_page = 1;
$limit_sql = '';
$pagination = 'no';

if( $pagination == 'yes' ) {
    $count = array();

    if( is_user_logged_in() || ( isset( $user_id ) && !empty( $user_id ) ) ) {
        $count = $wpdb->get_results( $wpdb->prepare( 'SELECT COUNT(*) as `cnt` FROM `' . YITH_WCWL_TABLE . '` WHERE `user_id` = %d', $user_id  ), ARRAY_A );
        $count = $count[0]['cnt'];
    } elseif( yith_usecookies() ) {
        $count[0]['cnt'] = count( yith_getcookie( 'yith_wcwl_products' ) );
    } else {
        $count[0]['cnt'] = count( $_SESSION['yith_wcwl_products'] );
    }

    $total_pages = $count/$per_page;
    if( $total_pages > 1 ) {
        $current_page = max( 1, get_query_var( 'page' ) );

        $page_links = paginate_links( array(
            'base' => get_pagenum_link( 1 ) . '%_%',
            'format' => '&page=%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'show_all' => true
        ) );
    }

    $limit_sql = "LIMIT " . ( $current_page - 1 ) * 1 . ',' . $per_page;
}

if( is_user_logged_in() || ( isset( $user_id ) && !empty( $user_id ) ) )
{ $wishlist = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `" . YITH_WCWL_TABLE . "` WHERE `user_id` = %s" . $limit_sql, $user_id ), ARRAY_A ); }
elseif( yith_usecookies() )
{ $wishlist = yith_getcookie( 'yith_wcwl_products' ); }
else
{ $wishlist = isset( $_SESSION['yith_wcwl_products'] ) ? $_SESSION['yith_wcwl_products'] : array(); }

?>
<a href="<?php echo $yith_wcwl->get_wishlist_url(); ?>"><i class="fa fa-star"></i></a>
<?php if( count( $wishlist ) > 0 ) { ?>
<div class="minibar-content">
	<p class="total"><strong><?php _e( 'Total', 'singlepage' ); ?>:</strong> <?php echo count( $wishlist ); ?></p>
    <ul class="mline">
    <?php
		foreach( $wishlist as $values ) {
				if( !is_user_logged_in() && !isset( $_GET['user_id'] ) ) {
                    if( isset( $values['add-to-wishlist'] ) && is_numeric( $values['add-to-wishlist'] ) ) {
                        $values['prod_id'] = $values['add-to-wishlist'];
                        $values['ID'] = $values['add-to-wishlist'];
                    } else {
                        $values['prod_id'] = $values['product_id'];
                        $values['ID'] = $values['product_id'];
                    }
                }

                $product_obj = get_product( $values['prod_id'] );

                if( $product_obj !== false && $product_obj->exists() ) { ?>
                <li>
                    <a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $values['prod_id'] ) ) ) ?>">
                        <?php echo $product_obj->get_image() ?>
                    </a>
                    <div class="wish-list_product-content">
                        <div class="wish-list_product-name">
                            <?php echo apply_filters( 'woocommerce_in_cartproduct_obj_title', $product_obj->get_title(), $product_obj ) ?>
                        </div>
    
                        <div class="wish-list_product-data">
                            <?php
                            if( $product_obj->price != '0' ) {
                                if( get_option( 'woocommerce_tax_display_cart' ) == 'excl' )
                                    { echo apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price_excluding_tax() ), $values, '' ); }
                                else
                                    { echo apply_filters( 'woocommerce_cart_item_price_html', woocommerce_price( $product_obj->get_price() ), $values, '' ); }
                            } else {
                                echo apply_filters( 'yith_free_text', __( 'Free!', 'singlepage' ) );
                            }
                            ?>
                        </div>
                     </div>
                 </li>
         <?php
				}
		
			}?>
    </ul><!-- end product list -->
	<a href="<?php echo $yith_wcwl->get_wishlist_url(); ?>" class="btn btn-theme checkout"><?php _e( 'Go to your Wishlist', 'singlepage' ); ?></a>
<?php }else { ?>
<div class="minibar-content empty">
    <p><?php _e( 'No products were added to the wishlist', 'singlepage' ); ?></p>
    <p><a href="<?php echo $yith_wcwl->get_wishlist_url(); ?>" class="btn btn-theme"><?php _e( 'Go to your Wishlist', 'singlepage' ); ?></a></p>
<?php } ?>

</div>