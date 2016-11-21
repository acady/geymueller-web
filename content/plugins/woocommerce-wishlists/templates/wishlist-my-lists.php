<table class="table" cellspacing="0">
	<thead>
		<tr>
			<th class="product-image"></th>
			<th class="product-name"><?php _e('List Name', 'wc_wishlist'); ?></th>
			<th class="wl-date-added"><?php _e('Date Added', 'wc_wishlist'); ?></th>
		</tr>
	</thead>
	<tbody>

		<?php foreach ($lists as $list) : ?>
			<?php
			$sharing = $list->get_wishlist_sharing();
			if($sharing == $sharingfilter){
			?>

			<tr class="cart_table_item">
				<td class="product-image">
					<?php
					  $wishlist_items = WC_Wishlists_Wishlist_Item_Collection::get_items( $list->id, true );
                      foreach ( $wishlist_items as $wishlist_item_key => $item ) {
					    $_product = $item['data'];
					    echo $_product->get_image();
					    break;
                      }
					?>
				</td>
				<td class="product-name">
					<strong><a href="<?php $list->the_url_edit(); ?>"><?php $list->the_title(); ?></a></strong>
					<div class="row-actions">
						<span class="edit">
							<small><a href="<?php $list->the_url_edit(); ?>"><?php _e('Manage this list', 'wc_wishlist'); ?></a></small>
						</span>
						|
						<span class="trash">
							<small><a class="ico-delete wlconfirm" data-message="<?php _e('Are you sure you want to delete this list?', 'wc_wishlist'); ?>" href="<?php $list->the_url_delete(); ?>"><?php _e('Delete', 'wc_wishlist'); ?></a></small>
						</span>
						<?php if ($sharing == 'Public' || $sharing == 'Shared') : ?>
							|
							<span class="view">
								<small><a href="<?php $list->the_url_view(); ?>&preview=true"><?php _e('Preview', 'wc_wishlist'); ?></a></small>
							</span>
						<?php endif; ?>
					</div>
				</td>
				<td class="wl-date-added"><?php echo date(get_option('date_format'), strtotime($list->post->post_date)); ?></td>
			</tr>
			
			<?php
			}
			?>
			
		<?php endforeach; ?>

	</tbody>
</table>