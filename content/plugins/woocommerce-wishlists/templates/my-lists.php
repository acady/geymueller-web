<?php do_action('woocommerce_wishlists_before_wrapper'); ?>
<?php $lists = WC_Wishlists_User::get_wishlists(); ?>
<div id="wl-wrapper" class="woocommerce">

	<?php if (function_exists('wc_print_messages')) : ?>
		<?php wc_print_messages(); ?>
	<?php else : ?>
		<?php WC_Wishlist_Compatibility::wc_print_notices(); ?>
	<?php endif; ?>

	<?php
	$wl_owner = get_current_user_id();
	if( isset($_POST['display_name']) )
	{
	  wp_update_user( array( 'ID' => $wl_owner, 'display_name' => $_POST['display_name'] ) );
	}
	if( isset($_POST['deswebcription']) )
	{
	  wp_update_user( array( 'ID' => $wl_owner, 'description' => $_POST['description'] ) );
	}
	?>
	
	<form action="" method="post">
	  <div class="form-group">
	    <label for="user-displayname"><?php _e( 'Name of Owner', 'wc_wishlist' ); ?></label>
	    <input type="text" id="user-displayname" class="form-control" name="display_name" value="<?php echo get_userdata($wl_owner)->display_name; ?>">
	  </div>
	  <div class="form-group">
	    <label for="user-displayname"><?php _e( 'Description of Owner', 'wc_wishlist' ); ?></label>
	    <input type="text" id="user-displayname" class="form-control" name="description" value="<?php echo get_userdata($wl_owner)->description; ?>">
	  </div>
	  <button type="submit" class="btn btn-primary">
		  <?php _e('Save Description of Owner', 'wc_wishlist'); ?>
	  </button>
	</form>

	<br/>
	
	<div class="wl-row">
		<a href="<?php echo WC_Wishlists_Pages::get_url_for('create-a-list'); ?>" class="button alt wl-create-new"><?php _e('Create a New List', 'wc_wishlist'); ?></a>
	</div>

	<br/>

	<?php if ($lists && count($lists)) : ?>
	        <form method="post">

			<?php echo WC_Wishlists_Plugin::nonce_field('edit-lists'); ?>
			<?php echo WC_Wishlists_Plugin::action_field('edit-lists'); ?>
			<?php $lists = WC_Wishlists_User::get_wishlists(); ?>

			<uib-tabset ng-cloak="">
			<uib-tab heading="<?php _e('Private', 'wc_wishlist'); ?>">
				<?php woocommerce_wishlists_get_template('wishlist-my-lists.php', array('lists' => $lists, 'sharingfilter' => 'Private')); ?>
			</uib-tab>
			<uib-tab heading="<?php _e('Shared', 'wc_wishlist'); ?>">
				<?php woocommerce_wishlists_get_template('wishlist-my-lists.php', array('lists' => $lists, 'sharingfilter' => 'Shared')); ?>
			</uib-tab>
			<uib-tab heading="<?php _e('Public', 'wc_wishlist'); ?>">
				<?php woocommerce_wishlists_get_template('wishlist-my-lists.php', array('lists' => $lists, 'sharingfilter' => 'Public')); ?>
			</uib-tab>
	        </form>
	<?php else : ?>
		<?php $shop_url = get_permalink(woocommerce_get_page_id('shop')); ?>
		<?php _e('You have not created any lists yet.', 'wc_wishlist'); ?>
	<?php endif; ?>

	<?php
	if ($lists && count($lists)) :
		foreach ($lists as $list) :
			$sharing = $list->get_wishlist_sharing();
			if ($sharing == 'Public' || $sharing == 'Shared') :
				woocommerce_wishlists_get_template('wishlist-email-form.php', array('wishlist' => $list));
			endif;
		endforeach;
	endif;
	?>
</div><!-- /wishlist-wrapper -->
<?php do_action('woocommerce_wishlists_after_wrapper'); ?>
