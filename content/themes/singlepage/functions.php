<?php

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
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
//    wp_register_script('global', get_bloginfo('template_url') . '/js/optimized.min.js', array('require'), false, true);
    wp_enqueue_script('global');


    wp_enqueue_style('global', get_bloginfo('template_url') . '/css/global.css');
}

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
 * Mobile Detect Library
 **/
 if(!class_exists("Mobile_Detect"))
load_template( trailingslashit( get_template_directory() ) . 'includes/Mobile_Detect.php' );

 
/**
 * Theme setup
 **/
 
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-setup.php' );

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
 * Theme Metabox
 */
 
load_template( trailingslashit( get_template_directory() ) . 'includes/metabox-options.php' );
