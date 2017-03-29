<?php
function theme_enqueue_scripts(){

    wp_register_script('require', get_bloginfo('template_url') . '/js/vendor/requirejs/require.js', array(), false, true);
    wp_enqueue_script('require');

    /* LOCAL */
    /*
    wp_register_script('global', get_bloginfo('template_url') . '/js/global.js', array('require'), false, true);
    wp_enqueue_script('global');
    wp_register_script('livereload', 'http://realonline.imareal.sbg.ac.at.local:35729/livereload.js?snipver=1', null, false, true);
    wp_enqueue_script('livereload');
    */

    /* PRODUCTION */
    wp_register_script('global', get_bloginfo('template_url') . '/js/global.js', array('require'), false, true);
    // wp_register_script('global', get_bloginfo('template_url') . '/js/optimized.min.js', array('require'), false, true);
    wp_enqueue_script('global');


    wp_enqueue_style('global', get_bloginfo('template_url') . '/css/global.css');
}

/**
 * Load options framework
 **/
define('SINGLEPAGE_THEME_URI' ,trailingslashit( get_template_directory_uri()));
define('SINGLEPAGE_THEME_DIR' ,trailingslashit( get_template_directory()));
define('SINGLEPAGE_LIB_HOO_DIR' ,trailingslashit( get_template_directory()) .'lib/hoo-core/');
define('SINGLEPAGE_LIB_HOO_URI' ,trailingslashit( get_template_directory_uri()) .'lib/hoo-core/');
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/' );
require_once dirname( __FILE__ ) . '/admin/options-framework.php';
require_once get_template_directory() . '/options.php';

function singlepage_prefix_options_menu_filter( $menu ) {
	$menu['mode'] = 'menu';
	$menu['page_title'] = __( 'Theme Options', 'singlepage');
	$menu['menu_title'] = __( 'Theme Options', 'singlepage');
	$menu['menu_slug'] = 'singlepage-options';
	return $menu;
}

add_filter( 'optionsframework_menu', 'singlepage_prefix_options_menu_filter' );

/**
 * Load optiontree
 **/

;
add_filter( 'ot_theme_mode', '__return_true', 999 );
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_allow_unfiltered_html', '__return_true' );
add_filter( 'ot_use_theme_options', '__return_false' );

load_template( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );
load_template( trailingslashit( get_template_directory() ) . 'includes/meta-boxes.php' );

/**
 * Mobile Detect Library
 **/
 if(!class_exists("Mobile_Detect"))
load_template( trailingslashit( get_template_directory() ) . 'includes/Mobile_Detect.php' );

/**
 * Theme setup
 **/
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-setup.php' );


/**
 * Load singlepage slider
 **/
 
load_template( trailingslashit( get_template_directory() ) . 'includes/singlepage-slider.php' );

/**
 * Theme widgets
 **/
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-widgets.php' );

/**
 * Theme Functions
 **/
 
load_template( trailingslashit( get_template_directory() ) . 'includes/custom-functions.php' );

/**
 * Theme breadcrumb
 */
 
load_template( trailingslashit( get_template_directory() ) . 'includes/breadcrumb-trail.php' );

/**
 * Importer
 */
 
require trailingslashit( get_template_directory() )  . 'includes/importer/importer.php';

/**
 * Theme updater
 */
require 'includes/theme-updater.php';

/**
 * Theme shortcodes
 */
load_template( trailingslashit( get_template_directory() ) . 'lib/hoo-core/hoo-core.php' );

/**
 * Theme widgets
 */

foreach( glob( get_template_directory() . '/widgets/*.php' ) as $filename ) {
				require_once $filename;
			}

/**
 * woocommerce
 */
load_template( trailingslashit( get_template_directory() ) . 'includes/aq_resizer.php' );
if (class_exists( 'woocommerce' )) {
	require_once('woocommerce/woocommerce-config.php');
	$default_page_num = intval( of_get_option('woocommerce_page_num',12) );
	$products_per_page = isset($_GET['woo-per-page-num'])?intval( $_GET['woo-per-page-num'] ) : $default_page_num ;
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$products_per_page.';' ), 20 );
	
}

add_filter('widget_text', 'do_shortcode');