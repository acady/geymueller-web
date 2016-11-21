<?php
$current_user = wp_get_current_user();
?>
<?php do_action( 'woocommerce_wishlists_before_wrapper' ); ?>
<div id="wl-wrapper" class="woocommerce">
	<?php if ( function_exists( 'wc_print_messages' ) ) : ?>
		<?php wc_print_messages(); ?>
	<?php else : ?>
		<?php WC_Wishlist_Compatibility::wc_print_notices(); ?>
	<?php endif; ?>
	<div class="wl-form">
		<form  action="" enctype="multipart/form-data" method="post">
			<input type="hidden" name="wl_return_to" value="<?php echo (isset( $_GET['wl_return_to'] ) ? $_GET['wl_return_to'] : ''); ?>" />
			<?php echo WC_Wishlists_Plugin::action_field( 'create-list' ); ?>
			<?php echo WC_Wishlists_Plugin::nonce_field( 'create-list' ); ?>

			<div class="form-group">
				<label for="wishlist_title"><?php _e( 'Name your list', 'wc_wishlist' ); ?><abbr class="required" title="required">*</abbr></label>
				<div class="input-container">
					<input type="text" name="wishlist_title" id="wishlist_title" class="input-text" value="" />
				</div>
			</div>
			<div class="form-group">
				<label for="wishlist_description"><?php _e( 'Describe your list', 'wc_wishlist' ); ?></label>
				<div class="input-container">
					<textarea name="wishlist_description" id="wishlist_description"></textarea>
				</div>
			</div>
			<div class="form-group">
				<p><strong><?php _e( 'Privacy Settings', 'wc_wishlist' ); ?><abbr class="required" title="required">*</abbr></strong></p>
			<table class="wl-rad-table">
				<tr>
					<td><input type="radio" name="wishlist_sharing" id="rad_priv" value="Private" checked="checked"><label for="rad_priv"><?php _e( 'Private', 'wc_wishlist' ); ?> <span class="wl-small">- <?php _e( 'Only you can see this list.', 'wc_wishlist' ); ?></span></label></td>
				</tr>
				<tr>
					<td><input type="radio" name="wishlist_sharing" id="rad_shared" value="Shared"><label for="rad_shared"><?php _e( 'Shared', 'wc_wishlist' ); ?> <span class="wl-small">- <?php _e( 'Only people with the link can see this list. It will not appear in public search results.', 'wc_wishlist' ); ?></span></label></td>
				</tr>
				<tr>
					<td><input type="radio" name="wishlist_sharing" id="rad_pub" value="Public" checked="checked"><label for="rad_pub"><?php _e( 'Public', 'wc_wishlist' ); ?> <span class="wl-small">- <?php _e( 'Anyone can search for and see this list. You can also share using a link.', 'wc_wishlist' ); ?></span></label></td>
				</tr>
			</table>
			</div>

			<div class="form-group">
				<?php if( function_exists( 'gglcptch_display' ) ) { echo gglcptch_display(); } ; ?>
			</div>
			
			<div class="form-row">
				<input type="submit" class="button alt" name="update_wishlist" value="<?php _e( 'Create List', 'wc_wishlist' ); ?>">
			</div>
			
			
			
		</form>
	</div><!-- /wl form -->
</div><!-- /wishlist-wrapper -->
<?php do_action( 'woocommerce_wishlists_after_wrapper' ); ?>
