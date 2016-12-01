<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new hoo_shortcodes( $popup );

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="hoo-popup">

	<div id="hoo-shortcode-wrap">

		<div id="hoo-sc-form-wrap">

			<?php
			$select_shortcode = array(
					'select' => __('Choose a Shortcode', 'singlepage'),
					'accordion' => __('Accordion','singlepage'),
					'alert' => __('Alert','singlepage'),
					'blog' => __('Blog','singlepage'),
					'boxed' => __('Boxed','singlepage'),
					'button' => __('Button','singlepage'),
					'column' => __('Columns','singlepage'),
					'contact_form' => __('Contact Form','singlepage'),
					'counter' => __('Counter', 'singlepage'),
					'dropcap' => __('Dropcap','singlepage'),
					'fullwidth' => __('Fullwidth Container','singlepage'),
					'googlemap' => __('Google Map','singlepage'),
					//'fact' => 'Fact',
					'imagecarousel' => __('Image Carousel','singlepage'),
					'list' => __('List','singlepage'),
					'portfolio' => __('Portfolios','singlepage'),
					'hoo_post' => __('Post Data','singlepage'),
					'pricingtable' => __('Pricing Table','singlepage'),
					'progressbar' => __('Progress Bar','singlepage'),
					'separator' => __('Separator','singlepage'),
					'service' => __('Service','singlepage'),
					'social' => __('Social Icon','singlepage'),
					'team' => __('Team Member','singlepage'),
					'testimonials'=> __('Testimonials','singlepage'),
					'title' => __('Title','singlepage'),
					
			);
			?>
			<table id="hoo-sc-form-table" class="hoo-shortcode-selector">
				<tbody>
					<tr class="form-row">
						<td class="label"><?php _e('Choose Shortcode','singlepage');?></td>
						<td class="field">
							<div class="hoo-form-select-field">
							<div class="hoo-shortcodes-arrow">&#xf107;</div>
								<select name="hoo_select_shortcode" id="hoo_select_shortcode" class="hoo-form-select hoo-input">
									<?php foreach($select_shortcode as $shortcode_key => $shortcode_value): ?>
									<?php if($shortcode_key == $popup): $selected = 'selected="selected"'; else: $selected = ''; endif; ?>
									<option value="<?php echo $shortcode_key; ?>" <?php echo $selected; ?>><?php echo $shortcode_value; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<form method="post" id="hoo-sc-form">

				<table id="hoo-sc-form-table">

					<?php echo $shortcode->output; ?>

					<tbody class="hoo-sc-form-button">
						<tr class="form-row">
							<td class="field"><a href="javascript:;" class="hoo-insert"><?php _e('Insert Shortcode','singlepage');?></a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#hoo-sc-form-table -->

			</form>
			<!-- /#hoo-sc-form -->

		</div>
		<!-- /#hoo-sc-form-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#hoo-shortcode-wrap -->

</div>
<!-- /#hoo-popup -->

</body>
</html>