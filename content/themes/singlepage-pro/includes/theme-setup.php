<?php

function singlepage_setup(){
	global $content_width;
	$lang = get_template_directory(). '/languages';
	load_theme_textdomain('singlepage', $lang);
	add_theme_support( 'post-thumbnails' ); 
	$args = array();
	$header_args = array( 
	    'default-image'          => '',
		'default-repeat' => 'no-repeat',
        'default-text-color'     => 'eeeeee',
		'url'                    => '',
        'width'                  => 1920,
        'height'                 => 89,
        'flex-height'            => true
     );
	add_theme_support( 'custom-background', $args );
	add_theme_support( 'custom-header', $header_args );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('nav_menus');
	add_theme_support( "title-tag" );
	// Woocommerce Support
    add_theme_support( 'woocommerce' );

	register_nav_menus( array('primary' => __( 'Primary Menu', 'singlepage' )));
	register_nav_menus( array('home' => __( 'Home Page Top Menu', 'singlepage' )));
	add_editor_style("editor-style.css");
	add_image_size( 'blog', 609, 214 , true);
	add_image_size( 'portfolio', 700, 520 , true);
	add_image_size( 'portfolio-thumb', 300, 230, true ); //(cropped)
	if ( !isset( $content_width ) ) $content_width = 1170;
}

add_action( 'after_setup_theme', 'singlepage_setup' );


 function singlepage_custom_scripts(){
	 global $smof_data,$is_IE;
	$theme_info = wp_get_theme();
	$post_type =  get_post_type( get_the_ID() );
	$detect                    = new Mobile_Detect;
	$video_background_section  = absint(of_get_option( 'video_background_section',0));
	$youtube_video_background_section = of_get_option( 'youtube_video_background_section' ,'0' );
	$youtube_video                    = of_get_option( 'youtube_video' ,'' );
	$api_key                          = of_get_option( 'gmap_api_key' ,'' );

	// use jQuery 2.1.1 instead of the version provided with WordPress. jquery.easing needs this to work
  wp_deregister_script('jquery');
  wp_register_script('jquery', get_template_directory_uri().'/js/vendor/jquery/dist/jquery.js', false, '2.1.1');
  wp_enqueue_script('jquery');

	if( $youtube_video_background_section > 0 && $youtube_video != '' && (is_home() || is_front_page() ) ):
	wp_enqueue_style('jquery.mb.YTPlayer',  get_template_directory_uri() .'/js/YTPlayer/css/jquery.mb.YTPlayer.min.css', false, '4.0.3', false);
	wp_enqueue_script( 'jquery.mb.YTPlayer', get_template_directory_uri().'/js/YTPlayer/jquery.mb.YTPlayer.js', array( 'jquery' ), '', false );
	endif;
	
	$load_google_fonts = of_get_option('load_google_fonts');
    if( trim($load_google_fonts) !='' ){
	$google_fonts = str_replace(' ','+',trim($load_google_fonts));
	wp_enqueue_style('singlepage-google-fonts', esc_url('//fonts.googleapis.com/css?family='.$google_fonts), false, '', false );
	}
	
	wp_enqueue_style('font-awesome',  get_template_directory_uri() .'/css/font-awesome.min.css', false, '4.2.0', false);
	wp_enqueue_style('bootstrap',  get_template_directory_uri() .'/css/bootstrap.css', false, '4.0.3', false);
	wp_enqueue_style('animate',  get_template_directory_uri() .'/css/animate.css', false, '', false);
	wp_enqueue_style('prettyPhoto',  get_template_directory_uri() .'/css/prettyPhoto.css', false, '', false);
	if( $video_background_section > 0 && (is_home() || is_front_page()) )
	wp_enqueue_style('jquery-ui',  get_template_directory_uri() .'/css/jquery-ui-1.8.12.custom.css', false, '', false);
	
	if (class_exists( 'woocommerce' )) { 
		wp_enqueue_style( 'singlepage-woocommerce', get_template_directory_uri().'/woocommerce/assets/css/woocommerce.css' , array() , $theme_info->get( 'Version' ) );
	}		
	wp_enqueue_style('singlepage-shortcodes',  get_template_directory_uri() .'/css/shortcodes.css', false,$theme_info->get( 'Version' ), false);
	wp_enqueue_style('singlepage-widgets',  get_template_directory_uri() .'/css/widgets.css', false, $theme_info->get( 'Version' ), false);
	wp_enqueue_style( 'singlepage-main', get_stylesheet_uri(), array(), $theme_info->get( 'Version' ) );
	
	wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array( 'jquery' ), '3.0.3', false );
	wp_enqueue_script( 'respond', get_template_directory_uri().'/js/respond.min.js', array( 'jquery' ), '1.4.2', false );
	wp_enqueue_script( 'modernizr.custom', get_template_directory_uri().'/js/modernizr.custom.js', array( 'jquery' ), '2.8.2', false );
  // load easing at document.ready() in template-home.php instead (see https://stackoverflow.com/questions/11533168)
	//wp_enqueue_script( 'jquery.easing', get_template_directory_uri().'/js/jquery.easing.1.3.js', array( 'jquery' ), '1.3 ', false );
	//wp_enqueue_script( 'singlepage-cycle', get_template_directory_uri().'/js/jquery.cycle.all.js', array( 'jquery' ), '1.3.2', false );
	
	
	wp_enqueue_script( 'jquery.cycle', get_template_directory_uri().'/js/jquery.cycle.js', array( 'jquery' ), '1.3.2', false );
	wp_enqueue_script( 'jquery.maximage', get_template_directory_uri().'/js/jquery.maximage.js', array( 'jquery' ), '2.0.8', false );
	
	wp_enqueue_script( 'jquery.nav', get_template_directory_uri().'/js/jquery.nav.js', array( 'jquery' ), '3.0.0', false );
	
	wp_enqueue_script( 'waypoints', get_template_directory_uri().'/js/waypoints.min.js', array( 'jquery' ), '1.6', false );
	wp_enqueue_script( 'wow', get_template_directory_uri().'/js/wow.min.js', array( 'jquery' ), '', false );
	wp_enqueue_script( 'prettify', get_template_directory_uri().'/js/prettify.js', array( 'jquery' ), '', false );
	wp_enqueue_script( 'hoverdir', get_template_directory_uri().'/js/jquery.hoverdir.js', array( 'jquery' ), '', false );

	wp_enqueue_script( 'owl.carousel', get_template_directory_uri().'/js/owl.carousel.min.js', array( 'jquery' ), '1.3.3', false );
	wp_enqueue_script( 'prettyPhoto', get_template_directory_uri().'/js/jquery.prettyPhoto.js', array( 'jquery' ), '', false );
	
	if(!$smof_data['status_gmap']) {
			$map_api = 'http' . ( ( is_ssl() ) ? 's' : '' ) . '://maps.googleapis.com/maps/api/js?key='.trim($api_key).'&amp;sensor=false&amp;language=' . substr(get_locale(), 0, 2);
			wp_register_script( 'google-maps-api', $map_api, array(), $theme_info->get( 'Version' ), false );
			wp_register_script( 'google-maps-infobox', get_template_directory_uri().'/js/infobox.js', array(), '', false);
		}
	
	
	if( $video_background_section > 0 && (is_home() || is_front_page() )){
	wp_enqueue_script( 'jquery-ui', get_template_directory_uri().'/js/jquery-ui.min.js', array( 'jquery' ), '1.10.3', false );
	//wp_enqueue_script( 'singlepage-video', get_template_directory_uri().'/js/video.js', array( 'jquery' ), '4.3.0', false );
	//wp_enqueue_script( 'singlepage-bigvideo', get_template_directory_uri().'/js/bigvideo.js', array( 'jquery' ), '', false );
	wp_enqueue_script( 'jquery.videobackground', get_template_directory_uri().'/js/jquery.videobackground.js', array( 'jquery' ),'', true );
	}
	
	$google_map_section  = of_get_option( 'google_map_section',0);
	if( $google_map_section>0 && (is_home() || is_front_page() ) )
	wp_enqueue_script( 'google-maps-api',esc_url('//maps.googleapis.com/maps/api/js?key='.trim($api_key).'&amp;v=3.exp&signed_in=true'), array( 'jquery' ), '', false );
	
	wp_enqueue_script( 'jquery.flexslider', get_template_directory_uri().'/js/jquery.flexslider.min.js', array( 'jquery' ), '2.2.0', false );
	if( $post_type == 'product' ){
	wp_enqueue_script( 'cloud-zoom', get_template_directory_uri().'/js/cloud-zoom.1.0.2.js', array( 'jquery' ), '1.0.2', false );
	}
	
	
	
	wp_enqueue_script( 'smoothscroll', get_template_directory_uri().'/js/smoothscroll.js', array( 'jquery' ), '0.9.9', false );
	wp_enqueue_script( 'singlepage-widgets', get_template_directory_uri().'/js/widgets.js', array( 'jquery' ), $theme_info->get( 'Version' ), true );
	wp_enqueue_script( 'singlepage-main', get_template_directory_uri().'/js/common.js', array( 'jquery' ), $theme_info->get( 'Version' ), true );
	
	if( $is_IE ) {
	wp_enqueue_script( 'html5', get_template_directory_uri().'/js/html5.js', array( 'jquery' ), '', false );
	}
	$scrolldelay                = absint(of_get_option('scrolldelay', 700));
	$section_height_mode        = absint(of_get_option('section_height_mode', 1));
	$section_height_mode_mobile = absint(of_get_option('section_height_mode_mobile', 2));
	
	$is_mobile = 0;
	if( $detect->isMobile() && !$detect->isTablet() ){
		$is_mobile = 1;
	}
	 
	wp_localize_script( 'singlepage-main', 'singlepage_params',  array(
			'ajaxurl'        => admin_url('admin-ajax.php'),
			'themeurl' => get_template_directory_uri(),
			'scrolldelay' => $scrolldelay,
			'is_mobile' => $is_mobile,
			'section_height_mode'=>$section_height_mode,
			'section_height_mode_mobile'=>$section_height_mode_mobile
		)  );
		
	
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){wp_enqueue_script( 'comment-reply' );}
	
	
	
	$background_array  = of_get_option("blog_background");
    $blog_background   = singlepage_get_background($background_array);
	
	$singlepage_custom_css   =  str_replace('&gt;','>',esc_html(of_get_option("custom_css")));
	
	$singlepage_custom_css  .=  'body#template-site{'.esc_html($blog_background).'}';
	
	//$header_image       = get_header_image();
	//if (isset($header_image) && ! empty( $header_image )) {
//	$singlepage_custom_css .= "header.navbar{background:url(".esc_url($header_image). ");}\n";
	
/*	$singlepage_custom_css .= "@media screen and (max-width: 919px){
           header.navbar {
			   background:url(".$header_image. ") !important;
			   margin-bottom:0;
	       }}\n";*/
	
	//}
	
	 if ( 'blank' != get_header_textcolor() && '' != get_header_textcolor() ){
     $header_color           =  ' color:#' . get_header_textcolor() . ';';
	 $singlepage_custom_css .=  '.site-name,.site-tagline{'.$header_color.'}';
		}
		
	$blog_title_color    = of_get_option('blog_title_color','#666666');
	if( $blog_title_color )
	$singlepage_custom_css  .=  '.post h1.title{color:'.$blog_title_color.';}';
	
	$home_nav_menu_color        = of_get_option("home_nav_menu_color",'#c2d5eb');
	$home_nav_menu_hover_color  = of_get_option("home_nav_menu_hover_color",'#ffffff');
	$singlepage_custom_css     .=  '#featured-template .nav li a{color:'.$home_nav_menu_color.'}';
	$singlepage_custom_css     .=  '#featured-template .nav .cur a{color:'.$home_nav_menu_hover_color.'}';
	
	$home_side_nav_menu_color         = of_get_option("home_side_nav_menu_color",'#dcecff');
	$home_side_nav_menu_active_color  = of_get_option("home_side_nav_menu_active_color",'#23dd91');
	$home_side_nav_background_color   = of_get_option("home_side_nav_background_color",'');
	$home_side_nav_background_opacity = of_get_option("home_side_nav_background_opacity",'0.5');
	$sidebar_menu_border_radius       = of_get_option("sidebar_menu_border_radius",'0px');
	
	$singlepage_custom_css           .=  '.sub_nav li{color:'.$home_side_nav_menu_color.'}';
	$singlepage_custom_css           .=  '.sub_nav .cur a,.sub_nav li a:hover{color:'.$home_side_nav_menu_active_color.' !important;}';
	
	$singlepage_custom_css     .=  '.nav li a{color:'.$home_nav_menu_color.'}';
	$singlepage_custom_css     .=  'nav > ul > li.current-post-ancestor > a, nav > ul > li.current-menu-parent > a, nav > ul > li.current-menu-item > a, nav > ul > li.current_page_item > a, .nav .cur > a	{color:'.$home_nav_menu_hover_color.'}';
	
	$home_side_nav_circle_color = of_get_option("home_side_nav_circle_color",'nav_cur0');
	 $home_side_nav_circle_image = of_get_option("home_side_nav_circle_image");
	if($home_side_nav_circle_image !='')
	$singlepage_custom_css     .=  '.sub_nav .cur{background-image:url('.esc_url($home_side_nav_circle_image).');}';
	else
        
	$singlepage_custom_css     .=  '.sub_nav .cur{background-image:url('.get_template_directory_uri().'/images/'.$home_side_nav_circle_color.'.png);}';
	if($home_side_nav_background_color){
		$rgb = singlepage_hex2rgb($home_side_nav_background_color);
	    $singlepage_custom_css     .=  "#featured-template #sub_nav .sub_nav{
			padding:15px;
			background-color: rgba(".$rgb[0].", ".$rgb[1].", ".$rgb[2].", ".esc_attr($home_side_nav_background_opacity).");
			border-radius:".$sidebar_menu_border_radius.";
			-moz-border-radius: ".$sidebar_menu_border_radius.";
			-webkit-border-radius: ".$sidebar_menu_border_radius.";
			}";
	}
	
	////Typography
	
	$content_link_color  = of_get_option("content_link_color",'#666');
	$singlepage_custom_css     .=  'a,#main-content .post .meta ul li a{color:'.$content_link_color.';}';
	
	$content_link_hover_color  = of_get_option("content_link_hover_color",'#fe8a02');
	$singlepage_custom_css     .=  'a:hover,#main #main-content .post .meta a:hover{color:'.$content_link_hover_color.';}';
	
	$page_menu_typography       = of_get_option("page_menu_typography",'');
	if( $page_menu_typography )
	$singlepage_custom_css     .=singlepage_options_typography_font_styles($page_menu_typography ,'#page-template .main-nav li a,#featured-template .main-nav li a');
	
	$home_nav_menu_hover_color  = of_get_option("home_nav_menu_hover_color",'#ffffff');
	if( $home_nav_menu_hover_color  )
	$singlepage_custom_css     .=  '#featured-template .main-nav li > a:hover,#page-template .main-nav li > a:hover,#page-template .main-nav .current-menu-item > a,#page-template .main-nav .current_page_parent > a{color:'.$home_nav_menu_hover_color.' ;}';
	
	$blog_menu_typography       = of_get_option("blog_menu_typography",'');
	if( $blog_menu_typography )
	$singlepage_custom_css     .=singlepage_options_typography_font_styles($blog_menu_typography ,'#template-site .main-nav li a,#template-site .main-nav li a,#template-site #navigation ul li a:link');
	
	$blog_menu_hover_color       = of_get_option("blog_menu_hover_color",'#eeee22');
	if( $blog_menu_hover_color  )
	$singlepage_custom_css     .=  '#template-site .main-nav li > a:hover,#template-site .main-nav .current-menu-item > a,#template-site .main-nav .current_page_parent > a{color:'.$blog_menu_hover_color.' !important;}';
	
	$homepage_side_nav_menu_typography       = of_get_option("homepage_side_nav_menu_typography",'');
	if( $homepage_side_nav_menu_typography )
	$singlepage_custom_css     .=singlepage_options_typography_font_styles($homepage_side_nav_menu_typography ,'#featured-template .sub_nav li,#featured-template .sub_nav li a');
	
	$home_side_nav_menu_active_color       = of_get_option("home_side_nav_menu_active_color",'#23dd91');
	if( $blog_menu_hover_color  )
	$singlepage_custom_css     .=  '#featured-template .sub_nav li.cur{color:'.$home_side_nav_menu_active_color.' ;}';
	
	
	$homepage_footer_background  = of_get_option("homepage_footer_background",'');
	if($homepage_footer_background){
    $singlepage_custom_css     .=  '#featured-template #footer{'.singlepage_get_background($homepage_footer_background).'}';
	}
/*	$homepage_section_content_typography       = of_get_option("homepage_section_content_typography",'');
	if( $homepage_section_content_typography )
	$singlepage_custom_css     .=singlepage_options_typography_font_styles($homepage_section_content_typography ,'section .section-content,section .section-title');
	*/
	
	
	$page_post_title_typography       = of_get_option("page_post_title_typography",'');
	if( $page_post_title_typography )
	$singlepage_custom_css     .=singlepage_options_typography_font_styles($page_post_title_typography ,'.entry-title');
	
	$page_post_content_typography       = of_get_option("page_post_content_typography",'');
	if( $page_post_content_typography )
	$singlepage_custom_css     .=singlepage_options_typography_font_styles($page_post_content_typography ,'.entry-content,.post p,.page p');
	
	
	//
	
	////
	
	$content_container_width_768   = of_get_option("content_container_width_768",'70%');
	$content_container_left_768    = of_get_option("content_container_left_768",'9%');
	$content_container_top_768     = of_get_option("content_container_top_768",'15%');
	$content_container_padding_768 = of_get_option("content_container_padding_768",'10px');
	
	$content_container_width_992   = of_get_option("content_container_width_992",'60%');
	$content_container_left_992    = of_get_option("content_container_left_992",'18%');
	$content_container_top_992     = of_get_option("content_container_top_992",'15%');
	$content_container_padding_992 = of_get_option("content_container_padding_992",'20px');
	
	$content_container_width_1200   = of_get_option("content_container_width_1200",'50%');
	$content_container_left_1200    = of_get_option("content_container_left_1200",'21%');
	$content_container_top_1200     = of_get_option("content_container_top_1200",'15%');
	$content_container_padding_1200 = of_get_option("content_container_padding_1200",'20px');
	
	$content_container_width_1200_r   = of_get_option("content_container_width_1200_r",'50%');
	$content_container_left_1200_r    = of_get_option("content_container_left_1200_r",'21%');
	$content_container_top_1200_r     = of_get_option("content_container_top_1200_r",'15%');
	$content_container_padding_1200_r = of_get_option("content_container_padding_1200_r",'20px');
	
	
	$singlepage_custom_css     .=  '
		section.section  .section-content{
			width:'.$content_container_width_1200_r.';
			margin-left:'.$content_container_left_1200_r.';
			margin-top:'.$content_container_top_1200_r.';
			padding:'.$content_container_padding_1200_r.';
			}
		';
	$singlepage_custom_css     .=  '@media screen and (max-width: 1200px) {
		section.section .section-content{
			width:'.$content_container_width_1200.';
			margin-left:'.$content_container_left_1200.';
			margin-top:'.$content_container_top_1200.';
			padding:'.$content_container_padding_1200.';
			}
		}';
	$singlepage_custom_css     .=  '@media screen and (max-width: 992px) {
		section.section .section-content{
			width:'.$content_container_width_992.';
			margin-left:'.$content_container_left_992.';
			margin-top:'.$content_container_top_992.';
			padding:'.$content_container_padding_992.';
			}
		}';
		
	$singlepage_custom_css     .=  '@media screen and (max-width: 768px) {
		section.section .section-content{
			width:'.$content_container_width_768.';
			margin-left:'.$content_container_left_768.';
			margin-top:'.$content_container_top_768.';
			padding:'.$content_container_padding_768.';
			}
		}';
	
	
	
	
	wp_add_inline_style( 'singlepage-main', $singlepage_custom_css );
	
	}

 function singlepage_admin_scripts(){
	 $theme_info = wp_get_theme();
	 wp_enqueue_script( 'singlepage-admin', get_template_directory_uri().'/js/admin.js', array( 'jquery' ), $theme_info->get( 'Version' ), true );
	 if(isset($_GET['page']) && $_GET['page'] == 'singlepage-options'){
	wp_enqueue_style('singlepage-font-awesome',  get_template_directory_uri() .'/css/font-awesome.min.css', false, '4.2.0', false);
	wp_enqueue_style('singlepage-admin',  get_template_directory_uri() .'/css/admin.css', false, $theme_info->get( 'Version' ), false);
	 }
	 
	$importer_failed = __('Import failed.','singlepage');
	$wait_text = __('Please wait, this may take a few minutes.','singlepage');
	$import_notice = __('Attention! Once you click this button to import data, some of your previous settings would be cleared.','singlepage');
	$confirm       = __('Are you sure you want to do this?','singlepage');
	 
	 wp_localize_script( 'singlepage-admin', 'singlepage', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'themeurl' => get_template_directory_uri(),
			'importer_failed' => $importer_failed,
			'wait_text' => $wait_text,
			'import_notice' => $import_notice,
			'confirm_text' => $confirm,
		)  );
	 
  }

  add_action( 'wp_enqueue_scripts', 'singlepage_custom_scripts' );
  add_action( 'admin_enqueue_scripts', 'singlepage_admin_scripts' );


// set default options
function singlepage_on_switch_theme(){
 
 // Import lite version options to pro version
 if(!get_option('singlepage_pro') && get_option('singlepage')){
	 
	 add_option( 'singlepage_pro',get_option('singlepage'));
	 
 }
 //
  if(!get_option( optionsframework_option_name() ) && get_option('singlepage_pro')){
	 
	 add_option( optionsframework_option_name() ,get_option('singlepage_pro'));
	 
 }

}
add_action( 'after_setup_theme', 'singlepage_on_switch_theme' );
add_action('after_switch_theme', 'singlepage_on_switch_theme');
