			</div>
			<footer id="page-footer">
				<div class="container">
					<div class="row footer-container" >
						<div class="col-lg-6" pulldown="">
							<div class="footer-logo">
								<span>
									<a href="http://www.imareal.sbg.ac.at" title="Institut für Realienkunde des Mittelalters und der frühen Neuzeit" target="_blank">
									<img src="<?php echo get_template_directory_uri(); ?>/images/logoFooter.png" />
									<!--<img src="<?php echo get_template_directory_uri(); ?>/images/logoFooterInvers.png" />-->
									</a>
								</span>
							</div>
						</div>
						<div class="col-lg-2" pulldown="">
							<!--<a href="<?php bloginfo('url') ?>" title="<?php bloginfo('name') ?> - <?php bloginfo('description') ?>">-->
							<a href="http://www.sbg.ac.at" title="Universltät Salzburg" target="_blank">
								<img src="<?php echo get_template_directory_uri(); ?>/images/logoBottom.png"/>
							</a>
							</span>
						</div>
						<div class="col-lg-4" pulldown="">
							<div class="bottomMenu text-right">
								<?php wp_nav_menu( array( 'theme_location' => 'footer-nav' ) ); ?>
							</div>
						</div>
					</div>
				</div>
			</footer>
			<script type="text/javascript">
				var wp_nonce = '<?php echo wp_create_nonce('wp_rest'); ?>';
			</script>
			<?php wp_footer() ?>
		</div>
	</body>
</html>
