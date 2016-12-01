<?php
defined( 'ABSPATH' ) or die( 'You cannot access this script directly' );
			
// Hook importer into admin init
add_action( 'wp_ajax_hoo_import_demo_data', 'hoo_importer' );
function hoo_importer() {
	global $wpdb;
    
	$fetch_attachments = false;
	
	if(isset($_POST['fetch_attachments']) && $_POST['fetch_attachments']== '1' )
	$fetch_attachments = true;
	
	
	if ( current_user_can( 'manage_options' ) ) {
		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true); // we are loading importers

		if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
			$wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			include $wp_importer;
		}
		
		 if ( is_plugin_active('wordpress-importer/wordpress-importer.php') ) {
             deactivate_plugins('wordpress-importer/wordpress-importer.php');    
         }

		 if ( !class_exists( 'WP_Import' ) ) { // if WP importer doesn't exist
			$wp_import = get_template_directory() . '/includes/importer/wordpress-importer.php';
	      	include $wp_import;
		}
		
		
		if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) { // check for main import class and wp import class

			$theme_xml_file = get_template_directory() . '/includes/importer/singlepagepro.xml';
			$theme_options_file = get_template_directory() . '/includes/importer/theme_options.txt';
			
			$layerslider_exists = true;
			$layer_directory = get_template_directory() . '/includes/importer/layersliders/';

			$revslider_exists = true;
			$rev_directory = get_template_directory() . '/includes/importer/revsliders/';
			
			// reading settings
			$homepage_title = 'Front Page';
			$posts_page_title = 'Blog';
			$shop_demo = true;

			
				// Import Theme Options

		
			$theme_options_txt = trim(file_get_contents( $theme_options_file ));
			//$options_data      = @unserialize( stripslashes( base64_decode($theme_options_txt) )  );
			$options_data      = @json_decode($theme_options_txt,true);
			 if( is_array($options_data) ){
			   update_option( optionsframework_option_name(), $options_data ); // update theme options
			 }
			 
			/* Import Woocommerce if WooCommerce Exists */
			if( class_exists('WooCommerce') && $shop_demo == true ) {
				$importer = new WP_Import();
		
				$importer->fetch_attachments = $fetch_attachments;
				ob_start();
				$importer->import($theme_xml_file);
				ob_end_clean();

				// Set pages
				$woopages = array(
					'woocommerce_shop_page_id' => 'Shop',
					'woocommerce_cart_page_id' => 'Cart',
					'woocommerce_checkout_page_id' => 'Checkout',
					'woocommerce_pay_page_id' => 'Checkout &#8594; Pay',
					'woocommerce_thanks_page_id' => 'Order Received',
					'woocommerce_myaccount_page_id' => 'My Account',
					'woocommerce_edit_address_page_id' => 'Edit My Address',
					'woocommerce_view_order_page_id' => 'View Order',
					'woocommerce_change_password_page_id' => 'Change Password',
					'woocommerce_logout_page_id' => 'Logout',
					'woocommerce_lost_password_page_id' => 'Lost Password'
				);
				foreach($woopages as $woo_page_name => $woo_page_title) {
					$woopage = get_page_by_title( $woo_page_title );
					if(isset( $woopage ) && $woopage->ID) {
						update_option($woo_page_name, $woopage->ID); // Front Page
					}
				}

				// We no longer need to install pages
				delete_option( '_wc_needs_pages' );
				delete_transient( '_wc_activation_redirect' );

				// Flush rules after install
				flush_rewrite_rules();
			} else {
			
				$importer = new WP_Import();
				/* Import Posts, Pages, Portfolio Content, FAQ, Images, Menus */
				$importer->fetch_attachments = $fetch_attachments;
				ob_start();
				$importer->import($theme_xml_file);
				
				ob_end_clean();

				flush_rewrite_rules();
			}

	
			
			// Set imported menus to registered theme locations
			$locations = get_theme_mod( 'nav_menu_locations' ); // registered menu locations in theme
			$menus = wp_get_nav_menus(); // registered menus

			if($menus) {
				
				foreach($menus as $menu) { // assign menus to theme locations
					
						if( $menu->name == 'Short' ) {
							$locations['primary'] = $menu->term_id;
							$locations['home'] = $menu->term_id;
							
						} 
					}
				}
	

			set_theme_mod( 'nav_menu_locations', $locations ); // set menus to locations

		
           // Import Layerslider
			if( function_exists( 'layerslider_import_sample_slider' ) && $layerslider_exists == true ) { // if layerslider is activated
				// Get importUtil
				include WP_PLUGIN_DIR . '/LayerSlider/classes/class.ls.importutil.php';

				$layer_files = hoo_get_import_files( $layer_directory, 'zip' );

				foreach( $layer_files as $layer_file ) { // finally import layer slider
					$import = new LS_ImportUtil($layer_file);
				}

				// Get all sliders
				// Table name
				$table_name = $wpdb->prefix . "layerslider";

				// Get sliders
				$sliders = $wpdb->get_results( "SELECT * FROM $table_name
													WHERE flag_hidden = '0' AND flag_deleted = '0'
													ORDER BY date_c ASC" );

				if(!empty($sliders)):
				foreach($sliders as $key => $item):
					$slides[$item->id] = $item->name;
				endforeach;
				endif;


			
			}

			// Import Revslider
			if( class_exists('UniteFunctionsRev') && $revslider_exists == true ) { // if revslider is activated
				$rev_files = hoo_get_import_files( $rev_directory, 'zip' );

				$slider = new RevSlider();
				foreach( $rev_files as $rev_file ) { // finally import rev slider data files

					$filepath = $rev_file;
					
					$_FILES["import_file"]["tmp_name"] = $filepath;

					ob_start();
					$slider->importSliderFromPost(true, false, $filepath);
					ob_clean();
					ob_end_clean();
				}
			}
			
				 
			// Set reading options
			$homepage = get_page_by_title( $homepage_title );
			$posts_page = get_page_by_title( $posts_page_title );
			
			if(isset( $homepage ) && $homepage->ID ) {
				update_option('show_on_front', 'page');
				update_option('page_on_front', $homepage->ID); // Front Page
			}
			
			if(isset( $posts_page ) && $posts_page->ID ) {
				update_option('page_for_posts', $posts_page->ID); // Blog Page
			}
 
          
			
			echo __('Imported' ,'singlepage');

			exit;
		
	}
}
	}


/*
* Returns all files in directory with the given filetype. Uses glob() for older
* php versions and recursive directory iterator otherwise.
*
* @param string $directory Directory that should be parsed
* @param string $filetype The file type
*
* @return array $files File names that match the $filetype
*/
function hoo_get_import_files( $directory, $filetype ) {
	$phpversion = phpversion();
	$files = array();

	// Check if the php version allows for recursive iterators
	if ( version_compare( $phpversion, '5.2.11', '>' ) ) {
		if ( $filetype != '*' )  {
			$filetype = '/^.*\.' . $filetype . '$/';
		} else {
			$filetype = '/.+\.[^.]+$/';
		}
		$directory_iterator = new RecursiveDirectoryIterator( $directory );
		$recusive_iterator = new RecursiveIteratorIterator( $directory_iterator );
		$regex_iterator = new RegexIterator( $recusive_iterator, $filetype );

		foreach( $regex_iterator as $file ) {
			$files[] = $file->getPathname();
		}
	// Fallback to glob() for older php versions
	} else {
		if ( $filetype != '*' )  {
			$filetype = '*.' . $filetype;
		}

		foreach( glob( $directory . $filetype ) as $filename ) {
			$filename = basename( $filename );
			$files[] = $directory . $filename;
		}
	}

	return $files;
}
