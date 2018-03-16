<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {

	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );
	if( is_child_theme() ){	
		$themename = str_replace("_child","",$themename );
		}
	$themename_lan = $themename;
	
	if( defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != 'en' )
	$themename_lan = $themename.'_'.ICL_LANGUAGE_CODE;
	
	if(function_exists('pll_current_language')){
	$default_lan = pll_default_language('slug');
	$current_lan = pll_current_language('slug');
	if($current_lan !='' && $default_lan != $current_lan)
	$themename_lan = $themename.'_'.$current_lan;
	}
	return $themename_lan;
}

 function singlepage_sliders(){
	 $singlepage_sliders[0] = __('Select a slider', 'singlepage');
         
	$singlepage_custom_slider = new WP_Query( array( 'post_type' => 'singlepage_slider', 'posts_per_page' => -1 ) );
	while ( $singlepage_custom_slider->have_posts() ) {
		$singlepage_custom_slider->the_post();

		$singlepage_sliders[get_the_ID()] =  get_the_title();
           
	}
	wp_reset_postdata();
	return $singlepage_sliders;
	 }

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

    $theme_info    = wp_get_theme();
    $imagepath     =  get_template_directory_uri() . '/images/';
	$theme_options = get_option( optionsframework_option_name(),true );
	$theme_options_export = '';
	if(is_array($theme_options))
	$theme_options_export = base64_encode(addslashes(serialize($theme_options)));

	 
	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);
   $blog_background = array(
		'color' => '',
		'image' => $imagepath.'blog-background.jpg',
		'repeat' => 'repeat-y',
		'position' => 'top left',
		'attachment'=>'fixed');
   

	

	$options = array();
	$section_num = of_get_option( 'section_num', 4 );

	$options[] = array(
		'name' => __('Basic Settings', 'singlepage'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Google Map API Key', 'singlepage'),
		'id' => 'gmap_api_key',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Upload Logo', 'singlepage'),
		'id' => 'logo',
		'std' => '',
		'type' => 'upload');
		
	
	//$options[] = array('name' =>  __('Blog Page Background', 'singlepage'),'id' => 'blog_background','std' => $blog_background,'type' => 'background' );
	
	$options[] = array(
		'name' => __('404 Page Content', 'singlepage'),
		'id' => 'page_404_content',
		'std' => '<div class="text-center">
                                    <img class="img-404" src="'.$imagepath .'404.png" alt="404 not found" />
                                    <br/> <br/>
                                    <a href="'.esc_url(home_url("/")).'"><i class="fa fa-home"></i> Please, return to homepage!</a>
                                    </div>',
		'type' => 'editor');
	
	$options[] = array(
		'name' => __('Custom CSS', 'singlepage'),
		'desc' => __('The following css code will add to the header before the closing &lt;/head&gt; tag.', 'singlepage'),
		'id' => 'custom_css',
		'std' => 'body{margin:0px;}',
		'type' => 'textarea');
	
	
	$options[] = array(
		'name' => __('Header Tracking Code', 'singlepage'),
		'desc' => __('The following css code will add to the header before the closing &lt;/head&gt; tag.', 'singlepage'),
		'id' => 'header_code',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => __('Footer Tracking Code', 'singlepage'),
		'desc' => __('The following css code will add to the footer before the closing &lt;/body&gt; tag.', 'singlepage'),
		'id' => 'footer_code',
		'std' => '',
		'type' => 'textarea');
	
		
     $options[] = array(
		'name' => __('Home Page', 'singlepage'),
		'type' => 'heading');
	  
	
	 $options[] = array(
		'name' => __( 'Section Height Mode ( Desktop & Tablet )', 'singlepage' ),
		'desc' => '',
		'id' => 'section_height_mode',
		'std' => '1',
		'type' => 'radio',
		'options' => array(
						1=> __( 'One Section per Screen', 'singlepage' ),
						2=> __( 'Section Height Extensible', 'singlepage' ),
						   )
		);
	 
	 
	 $options[] = array(
		'name' => __( 'Section Height Mode on Mobile', 'singlepage' ),
		'desc' => '',
		'id' => 'section_height_mode_mobile',
		'std' => '2',
		'type' => 'radio',
		'options' => array(
						1=> __( 'One Section per Screen', 'singlepage' ),
						2=> __( 'Section Height Extensible', 'singlepage' ),
						   )
		);
	 
	 
	 
	$options[] = array('name' => __('Scrolling Delay', 'singlepage'),'class'=>'mini','id' => 'scrolldelay','type' => 'text','std'=>'700','desc'=> '');
	 	 
	$background_sections = array("0"=>__('Disable', 'singlepage'));
		if( is_numeric( $section_num ) ){
		for($i=1; $i <= $section_num; $i++){
			$background_sections[$i] = sprintf(__('Section %d', 'singlepage'),$i);
			}
		}
		
		// YouTube Video Background Options 
		
		
		  $options[] = array(	'desc' =>'<div class="options-section"><h3 class="groupTitle">'.__('YouTube Video Background Options', 'singlepage').'</h3>',	'class' => 'toggle_option_group group_close','type' => 'info');
		 
	    $options[] = array('name' => __('YouTube Video', 'singlepage'),'id' => 'youtube_video','type' => 'text','std'=>'r1xohS2u69E' ,"desc"=>__('Insert here the ID or the complete URL of the YouTube video','singlepage'));
		
		
		$options[] = array(	'name' => __('Video Loop', 'singlepage'),	'id' => 'youtube_video_loop','std' => 'true','class' => 'mini','options' => array('true'=>__('yes', 'singlepage'),'false'=>__('no', 'singlepage')),	'type' => 'select');
		
		$options[] = array(	'name' => __('Mute', 'singlepage'),	'id' => 'youtube_video_mute','std' => 'true','class' => 'mini','options' => array('true'=>__('yes', 'singlepage'),'false'=> __('no', 'singlepage')),	'type' => 'select');
		
		$options[] = array(	'name' => __('Show Controls', 'singlepage'),	'id' => 'youtube_show_controls','std' => 'false','class' => 'mini','options' => array('true'=>__('yes', 'singlepage'),'false'=> __('no', 'singlepage')),	'type' => 'select');
		
		$options[] = array('name' => __('Starts At', 'singlepage'),'id' => 'youtube_start_at','type' => 'text','std'=>'10' ,"desc"=>'');
		
		$options[]  = array('name' => __('Video Background Section', 'singlepage'),'std' => '0','class' => 'mini','id' => 'youtube_video_background_section',
		'type'  => 'select','options'=>$background_sections);
		

		$options[] = array('desc' => '</div>',	'class' => 'toggle_title','type' => 'info');
		
		
		 //// HTML5 Video Background Options 
	     
		  $options[] = array(	'desc' =>'<div class="options-section"><h3 class="groupTitle">'.__('HTML5 Video Background Options', 'singlepage').'</h3>',	'class' => 'toggle_option_group group_close','type' => 'info');
		 
	    $options[] = array('name' => __('mp4 video url', 'singlepage'),'id' => 'mp4_video_url','type' => 'text','std'=>'' ,"desc"=>__('For Android devices, Internet Explorer 9, Safari','singlepage'));
		$options[] = array('name' => __('ogv video url', 'singlepage'),'id' => 'ogv_video_url','type' => 'text','std'=>'',"desc"=>__('For Google Chrome, Mozilla Firefox, Opera ','singlepage'));
		$options[] = array('name' => __('webm video url', 'singlepage'),'id' => 'webm_video_url','type' => 'text','std'=>'',"desc"=>__('For Google Chrome, Mozilla Firefox, Opera ','singlepage'));
		$options[] = array('name' => __('poster', 'singlepage'),'id' => 'poster_url','type' => 'upload','std'=>'',"desc"=>__('Displaying the image for browsers that don\'t support the HTML5 Video element.','singlepage'));
		$options[] = array(	'name' => __('Video Loop', 'singlepage'),'id' => 'video_loop','std' => '1','class' => 'mini','options' => array('1'=>'yes','0'=>'no'),'type' => 'select');
		$options[] = array(	'name' => __('Video Autoplay', 'singlepage'),'id' => 'autoplay','std' => '1','class' => 'mini','options' => array('1'=>'yes','0'=>'no'),'type' => 'select');
		$options[] = array(	'name' => __('Display Buttons', 'singlepage'),'id' => 'display_buttons','std' => '1','class' => 'mini','options' => array('1'=>'yes','0'=>'no'),'type' => 'select');
		$options[] = array(	'name' => __('Video Volume', 'singlepage'),	'id' => 'video_volume','std' => '0.8','class' => 'mini','options' => array('0.001'=>'0','0.1'=>'0.1','0.2'=>'0.2','0.3'=>'0.3','0.4'=>'0.4','0.5'=>'0.5','0.6'=>'0.6','0.7'=>'0.7','0.8'=>'0.8','0.9'=>'0.9','1.0'=>'1.0'),	'type' => 'select');
		
		
		$options[]  = array('name' => __('Video Background Section', 'singlepage'),'std' => '0','class' => 'mini','id' => 'video_background_section',
		'type'  => 'select','options'=>$background_sections);
		
		$options[] = array('desc' => __('</div>', 'singlepage'),	'class' => 'toggle_title','type' => 'info');
		//// End HTML5 Video Background Options 
		
		 //// full screen google map 
	 
		$options[] = array(	'desc' =>'<div class="options-section"><h3 class="groupTitle">'.__('Full Screen Google Map Options', 'singlepage').'</h3>',	'class' => 'toggle_option_group group_close','type' => 'info');
		 
	   
		$options[] = array(	'name' => __('Address', 'singlepage'),	'id' => 'google_map_address','std' => 'Sydney, NSW','class' => 'mini','type' => 'text');
		$options[] = array(	'name' => __('Zoom', 'singlepage'),	'id' => 'google_map_zoom','std' => '10','class' => 'mini','type' => 'text');
		
		$options[] = array(	'name' => __('Start', 'singlepage'), 'id' => 'google_map_start','class' => 'mini','std'=>'','type' => 'text');
		$options[] = array(	'name' => __('End', 'singlepage'),	'id' => 'google_map_end','class' => 'mini','std'=>'','type' => 'text');
		$options[] = array(	'name' => __('Show Traffic', 'singlepage'),	'id' => 'google_map_traffic','class' => 'mini','std'=>'yes','type' => 'select','options' => array('yes'=>'yes','no'=>'no'));
		$options[] = array(	'name' => __('Scroll Wheel', 'singlepage'),	'id' => 'google_map_scrollwheel','class' => 'mini','std'=>'false','type' => 'select','options' => array('true'=>'yes','false'=>'no'));
		$options[] = array(	'name' => __('Scale Control', 'singlepage'),	'id' => 'google_map_scale','class' => 'mini','std'=>'false','type' => 'select','options' => array('true'=>'yes','false'=>'no'));
		$options[] = array(	'name' => __('Show Bike', 'singlepage'),	'id' => 'google_map_bike','class' => 'mini','std'=>'no','type' => 'select','options' => array('yes'=>'yes','no'=>'no'));
		
		$options[] = array(
		'name' => __('Marker Icon', 'singlepage'),
		'id' => 'google_map_icon',
		'std' => '',
		'type' => 'upload');
		$options[] = array(
		'name' => __('InfoWindow Content', 'singlepage'),
		'desc' =>'',
		'id' => 'google_map_infowindow',
		'std' => '',
		'type' => 'textarea');
		
		
		$options[]  = array('name' => __('Google Map Section', 'singlepage'),'std' => '0','class' => 'mini','id' => 'google_map_section',
		'type'  => 'select','options'=>$background_sections);
		
		$options[] = array('desc' => '</div>',	'class' => 'toggle_title','type' => 'info');
		//// End full screen google map Options
		
		// home page sidebar menu options
		$options[] = array(	'desc' =>'<div class="options-section"><h3 class="groupTitle">'.__('Home Page Sidebar Menu options', 'singlepage').'</h3>',	'class' => 'toggle_option_group group_close','type' => 'info');
		$options[] = array(	'name' => __('Menu Style ( Desktop )', 'singlepage'),'id' => 'menu_style_desktop','std' => '1','class' => 'mini','options' => array('1'=>'Style 1','2'=>'Style 2'),'type' => 'select');
		
		$options[] = array(	'name' => __('Menu Style Status ( Desktop )', 'singlepage'),'id' => 'menu_status_desktop','std' => 'open','class' => 'mini','options' => array('open'=>'open','close'=>'close'),'type' => 'select');
		
		
		$options[] = array(	'name' => __('Menu Style ( Tablet )', 'singlepage'),'id' => 'menu_style_tablet','std' => '1','class' => 'mini','options' => array('1'=>'Style 1','2'=>'Style 2'),'type' => 'select');
		
		$options[] = array(	'name' => __('Menu Style Status ( Tablet )', 'singlepage'),'id' => 'menu_status_tablet','std' => 'open','class' => 'mini','options' => array('open'=>'open','close'=>'close'),'type' => 'select');
		
		$options[] = array(	'name' => __('Menu Style ( Mobile )', 'singlepage'),'id' => 'menu_style_mobile','std' => '2','class' => 'mini','options' => array('1'=>'Style 1','2'=>'Style 2'),'type' => 'select');
		
		$options[] = array(	'name' => __('Menu Style Status ( Mobile )', 'singlepage'),'id' => 'menu_status_mobile','std' => 'close','class' => 'mini','options' => array('open'=>'open','close'=>'close'),'type' => 'select');
		
		
		$options[] = array('desc' => '</div>',	'class' => 'toggle_title','type' => 'info');
		
		// end page sidebar menu options
		
	 
	  $options[] = array(
		'name' => __('Number of Sections', 'singlepage'),
		'desc' => __('Select number of sections', 'singlepage'),
		'id' => 'section_num',
		'type' => 'select',
		'class' => 'mini',
		'std' => '4',
		'options' => array_combine(range(1,10), range(1,10)) );
	  
	 $section_menu_title              = array("SECTION ONE","SECTION TWO","SECTION THREE","SECTION FOUR","","","","","","");
	 $section_menu_slug               = array("section-one","section-two","section-three","section-four","","","","","","");
	 $section_content_color      = array("#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff");
	 $section_css_class          = array("","","","","","","","","","");
	 $section_background_size    = array("yes","no","no","yes","","","","","","");
	 $typography_mixed_fonts = array_merge( singlepage_options_typography_get_os_fonts() , singlepage_options_typography_get_google_fonts() );
        asort($typography_mixed_fonts);
		
	 $section_background = array(
	     array(
		'color' => '',
		'image' => $imagepath.'bg_01.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		 array(
		'color' => '',
		'image' => $imagepath.'bg_02.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		 array(
		'color' => '',
		'image' => $imagepath.'bg_03.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		 array(
		'color' => '',
		'image' => $imagepath.'bg_04.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' 
		 ),
	  array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' 
		 ),
		  array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' 
		 ),
		  array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' 
		 ),
		  array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		  array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		  array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' )
		 );
	 $section_image     = array(
								$imagepath.'1.png',
								$imagepath.'2.png',
							    $imagepath.'3.png',
								$imagepath.'4.png',
								'',
								'',
								'',
								'',
								'',
								''
								);
	 
	 $section_content   = array('<p><h1 class="section-title">Impressive Design</h1><br>
<ul>
	<li>Elegans Lorem Ratio amoena</li>
	<li>fons et oculorum captans iconibus</li>
	<li> haec omnia faciant ad melioris propositi vestri website</li>
</ul>
</p>',
		'<p><h1 class="section-title">Responsive Layout</h1><br>
</p>',
			'<p><h1 class="section-title">Flexibility</h1><br>
<ul>
	<li>Lorem ipsum dolor sit amet</li>
	<li>consectetur adipiscingelit</li>
	<li>Integer sed magna vel </li>
	<li>Dapibus ege-stas turpis.</li>
</ul>
</p>',
		'<p><h1 class="section-title">Continuous  Support</h1><br>
<ul>
	<li>Lorem ipsum dolor sit amet</li>
	<li>consectetur adipiscingelit</li>
	<li>Integer sed magna vel velit</li>
	<li>Dapibus ege-stas turpis.</li>
</ul>
</p>','','','','' ,'','');
	     
	   $options[] = array(	'desc' => '<div class="home-sections">', 'class' => '','id'=>'home-sections','type' => 'info');
	 		for($i=0; $i < $section_num; $i++){
		
		if(!isset($section_title[$i])){$section_title[$i] = "";}
		if(!isset($section_menu[$i])){$section_menu[$i] = "";}
		if(!isset($section_background[$i])){$section_background[$i] = array('color' => '',
		'image' => '',
		'repeat' => '',
		'position' => '',
		'attachment'=>'');}
		if(!isset($section_css_class[$i])){$section_css_class[$i] = "";}
		if(!isset($section_content[$i])){$section_content[$i] = "";}
		if(!isset($section_title_color[$i])){$section_title_color[$i] = "";}
		if(!isset($section_title_border_color[$i])){$section_title_border_color[$i] = "";}
		
		$holder_title = of_get_option('section_menu_title_'.$i)?of_get_option('section_menu_title_'.$i):sprintf(__('Section %s', 'singlepage'),($i+1));
		
		$options[] = array(	'desc' => '<div class="options-section"><h3 class="groupTitle"><i class="fa fa-arrows"></i> '.$holder_title.'</h3>', 'class' => 'toggle_option_group home-section group_close','type' => 'info');
		
		$options[] = array(
		'name' => '',
		'desc' => '<div style="overflow:hidden; background-color:#eee;"><a data-section="'.$i.'" href="javascript:;" class="delete-section" style="float:right;" title="'.__('Delete This Section', 'singlepage').'"><i class="fa fa-trash"></i> '.__('Delete this section', 'singlepage').'</a></div>',
		'id' => 'delete_section_'.$i,
		'std' => '',
		'type' => 'info',
		'class'=>'section-item section-delete-button');
		
		$options[] = array('name' => __('Section Full Width', 'singlepage'),'id' => 'section_full_width_'.$i.'','type' => 'checkbox','std'=>'','desc'=>__('Section container no padding', 'singlepage'));
		
		$options[] = array('name' => __('Section Menu Title', 'singlepage'),'id' => 'section_menu_title_'.$i.'','type' => 'text','std'=>$section_menu_title[$i]);
		$options[] = array('name' => __('Section Menu Slug', 'singlepage'),'id' => 'section_menu_slug_'.$i.'','type' => 'text','std'=>$section_menu_slug[$i]);
		
		$options[] = array('name' => __('Section Type', 'singlepage'),'std' => 'content','id' => 'section_type_'.$i.'','type' => 'select','class'=>'mini','options'=>array("content"=> __('Content', 'singlepage'),"slider"=>__('Slider', 'singlepage'),"link"=>__('Link', 'singlepage')));
		
		$options[] = array('name' => __('Section Menu External Link', 'singlepage'),'id' => 'section_menu_link_'.$i.'','type' => 'text','std'=>'http://','desc'=>__('Available in Link Section Type', 'singlepage'));
		
		$options[] = array('name' => __('External Link Target', 'singlepage'),'std' => 'content','id' => 'section_link_target_'.$i.'','type' => 'select','class'=>'mini','options'=>array("_blank"=>__('Blank', 'singlepage'),"_self"=>"Self"));
		
		
		$options[] = array("name" =>  __('Select Slide', 'singlepage'),"id" => "section_slider_".$i,'class'=>'mini',	'desc' => sprintf(__('<a href="%s">Create Slider</a>', 'singlepage'),admin_url('edit.php?post_type=singlepage_slider')),"std" => "First","type" => "select","options" => singlepage_sliders() );
		
		
		$options[] = array( 'name' => __('Section Content Typography', 'singlepage'),
			'id' => 'section_content_typography_'.$i,
			'std' => array( 'size' => '14px', 'face' => 'Open Sans, sans-serif', 'color' => '#eeee22'),
			'type' => 'typography',
			'options' => array(
			'faces' => $typography_mixed_fonts,
			'styles' => false )
			  );
		
		
		
		$options[] = array('name' =>  __('Section Background ( Desktop )', 'singlepage'),'id' => 'section_background_'.$i.'','std' => $section_background[$i],'type' => 'background' );
		$options[] = array('name' =>  __('Section Background ( Tablet )', 'singlepage'),'id' => 'section_background_tablet_'.$i.'','std' => array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' )
		 ,'type' => 'background' );
		
		$options[] = array('name' =>  __('Section Background ( Mobile )', 'singlepage'),'id' => 'section_background_mobile_'.$i.'','std' => array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' )
		 ,'type' => 'background' );
		
		
		$options[] = array('name' => __('100% Width Background Image', 'singlepage'),'std' => $section_background_size[$i],'id' => 'background_size_'.$i.'','type' => 'select','class'=>'mini','options'=>array("no"=>"no","yes"=>"yes"));
		
		
	   $options[] = array('name' => __('Section Css Class', 'singlepage'),'id' => 'section_css_class_'.$i.'','type' => 'text','std'=>$section_css_class[$i]);
	   $options[] = array('name' => __('Content Image', 'singlepage'),'id' => 'section_image_'.$i,	'std' =>  $section_image[$i],'type' => 'upload');
	   $options[] = array('name' => __('Content Image Link', 'singlepage'),'id' => 'section_image_link_'.$i.'','type' => 'text','std'=>'');
	   
	   $options[] = array('name' => __('Content Image Link Target', 'singlepage'),'std' => '','id' => 'section_image_link_target_'.$i.'','type' => 'select','class'=>'mini','options'=>array("_blank"=>"blank","_self"=>"self"));
	   
	   
	   $options[] = array('name' => __('Section Content', 'singlepage'),'id' => 'section_content_'.$i,'std' => $section_content[$i],'type' => 'editor','desc'=>__('If you have reordered the sections and found the section content is blank or can not be edited, please click the "Save Options" button to save options before you edit section content.', 'singlepage'));
	   
	   $options[] = array('name' =>  __('Section Content Background', 'singlepage'),'id' => 'section_content_background_'.$i,'std' => '','type' => 'color' );
	   $options[] = array(	'name' => __('Opacity', 'singlepage'),	'id' => 'opacity_'.$i,'std' => '0.5','class' => 'mini','options' => array('0.1'=>'0.1','0.2'=>'0.2','0.3'=>'0.3','0.4'=>'0.4','0.5'=>'0.5','0.6'=>'0.6','0.7'=>'0.7','0.8'=>'0.8','0.9'=>'0.9','1.0'=>'1.0'),	'type' => 'select');
	   $options[] = array('name' => __('Section Content Border Radius', 'singlepage'),'id' => 'border_radius_'.$i,'std'=>'10px','class' => 'mini','type' => 'text');
	   
	   $options[] = array('desc' => '</div>','class' => 'toggle_title','type' => 'info');
	
		}
		 $options[] = array( 'desc' => '</div>', 'class' => '','type' => 'info');
		
		$options[] = array(
		'name' => __('Featured Homepage Sidebar', 'singlepage'),
		'id' => 'featured_homepage_sidebar',
		'std' => '<div class="social-networks"><ul class="unstyled inline">
  <li class="facebook  display-icons"> <a rel="external" title="facebook" href="#"> <i class="fa fa-facebook fa-2x">&nbsp;</i> </a> </li>
  <li class="twitter  display-icons"> <a rel="external" title="twitter" href="#"> <i class="fa fa-twitter fa-2x">&nbsp;</i> </a> </li>
  <li class="flickr  display-icons"> <a rel="external" title="flickr" href="#"> <i class="fa fa-flickr fa-2x">&nbsp;</i> </a> </li>
  <li class="rss  display-icons"> <a rel="external" title="rss" href="#"> <i class="fa fa-rss fa-2x">&nbsp;</i> </a> </li>
  <li class="google-plus  display-icons"> <a rel="external" title="google-plus" href="#"> <i class="fa fa-google-plus fa-2x">&nbsp;</i> </a> </li>
  <li class="youtube  display-icons"> <a rel="external" title="youtube" href="#"> <i class="fa fa-youtube fa-2x">&nbsp;</i> </a> </li>
</ul></div>',
		'type' => 'editor');
		
		
		$options[] = array('name' => __('Content Container Width', 'singlepage'),'class'=>'mini','id' => 'content_container_width_768','type' => 'text','std'=>'70%','desc'=> __('Extra small devices Phones (<768px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Margin Left', 'singlepage'),'class'=>'mini','id' => 'content_container_left_768','type' => 'text','std'=>'30%','desc'=> __('Extra small devices Phones (<768px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Margin Top', 'singlepage'),'class'=>'mini','id' => 'content_container_top_768','type' => 'text','std'=>'15%','desc'=> __('Extra small devices Phones (<768px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Padding', 'singlepage'),'class'=>'mini','id' => 'content_container_padding_768','type' => 'text','std'=>'10px','desc'=> __('Extra small devices Phones (<768px)', 'singlepage'));
	
	$options[] = array('name' => __('Content Container Width', 'singlepage'),'class'=>'mini','id' => 'content_container_width_992','type' => 'text','std'=>'60%','desc'=> __('Small devices Tablets (<992px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Margin Left', 'singlepage'),'class'=>'mini','id' => 'content_container_left_992','type' => 'text','std'=>'18%','desc'=> __('Extra small devices Phones ( <992px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Margin Top', 'singlepage'),'class'=>'mini','id' => 'content_container_top_992','type' => 'text','std'=>'15%','desc'=> __('Extra small devices Phones ( <992px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Padding', 'singlepage'),'class'=>'mini','id' => 'content_container_padding_992','type' => 'text','std'=>'20px','desc'=> __('Extra small devices Phones (<992px)', 'singlepage'));
	
	
	$options[] = array('name' => __('Content Container Width', 'singlepage'),'class'=>'mini','id' => 'content_container_width_1200','type' => 'text','std'=>'50%','desc'=> __('Medium devices Desktops (<1200px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Margin Left', 'singlepage'),'class'=>'mini','id' => 'content_container_left_1200','type' => 'text','std'=>'21%','desc'=> __('Medium devices Desktops (<1200px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Margin Top', 'singlepage'),'class'=>'mini','id' => 'content_container_top_1200','type' => 'text','std'=>'15%','desc'=> __('Medium devices Desktops (<1200px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Padding', 'singlepage'),'class'=>'mini','id' => 'content_container_padding_1200','type' => 'text','std'=>'20px','desc'=> __('Medium devices Desktops (<1200px)', 'singlepage'));
	
	$options[] = array('name' => __('Content Container Width', 'singlepage'),'class'=>'mini','id' => 'content_container_width_1200_r','type' => 'text','std'=>'50%','desc'=> __('Large devices Desktops (&#8805;1200px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Margin Left', 'singlepage'),'class'=>'mini','id' => 'content_container_left_1200_r','type' => 'text','std'=>'21%','desc'=> __('Large devices Desktops (&#8805;1200px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Margin Top', 'singlepage'),'class'=>'mini','id' => 'content_container_top_1200_r','type' => 'text','std'=>'15%','desc'=> __('Large devices Desktops (&#8805;1200px)', 'singlepage'));
	$options[] = array('name' => __('Content Container Padding', 'singlepage'),'class'=>'mini','id' => 'content_container_padding_1200_r','type' => 'text','std'=>'20px','desc'=> __('Large devices Desktops (&#8805;1200px)', 'singlepage'));
	
	$options[] = array('name' =>  __('Homepage Footer Background', 'singlepage'),'id' => 'homepage_footer_background','std' =>$background_defaults,'type' => 'background' );

// FOOTER
	    $options[] = array('name' => __('Footer', 'singlepage'),'type' => 'heading');
	
	    $social_icons = array('fa fa-facebook'=>'facebook',
						  'fa fa-flickr'=>'flickr',
						  'fa fa-google-plus'=>'google plus',
						  'fa fa-linkedin'=>'linkedin',
						  'fa fa-pinterest'=>'pinterest',
						  'fa fa-twitter'=>'twitter',
						  'fa fa-tumblr'=>'tumblr',
						  'fa fa-digg'=>'digg',
						  'fa fa-rss'=>'rss',
						 
						  );
        for($i=0;$i<9;$i++){
			
	    $options[] = array("name" => sprintf(__('Social Icon #%s', 'singlepage'),($i+1)),	"id" => "social_icon_".$i,"std" => "","class" => 'mini',"type" => "select",	"options" => $social_icons );
		$options[] = array('name' => sprintf(__('Social Title #%s', 'singlepage'),($i+1)),'id' => 'social_title_'.$i,"class" => 'mini','type' => 'text');	
		$options[] = array('name' => sprintf(__('Social Link #%s', 'singlepage'),($i+1)),'id' => 'social_link_'.$i,'type' => 'text');	
		}
		
		$options[] = array(
		'name' => __('Copyright', 'singlepage'),
		'desc' => '',
		'id' => 'copyright',
		'std' => '&copy; 2015, Designed by <a href="http://www.hoothemes.com/">HooThemes</a>.',
		'type' => 'textarea');
		
		//Typography
		
		$options[] = array('name' => __('Typography', 'singlepage'),'type' => 'heading');
		
		$options[] = array('name' => __('Load Google Fonts', 'singlepage'),'class'=>'','id' => 'load_google_fonts','type' => 'text','std'=>'','desc'=> __('For example: Open+Sans:300,400,700|Oswald', 'singlepage'));
		
        $options[] = array('name' => __('Content Link Color', 'singlepage'),'id' => 'content_link_color','type' => 'color','std'=>'#666');
		$options[] = array('name' => __('Content Link Mouseover Color', 'singlepage'),'id' => 'content_link_hover_color','type' => 'color','std'=>'#fe8a02');
	 
		$options[] = array( 'name' => __('Page Menu Typography', 'singlepage'),

			'desc' => __('Homepage and Pages Menu Typography.', 'singlepage'),
			'id' => 'page_menu_typography',
			'std' => array( 'size' => '14px', 'face' => 'Open Sans, sans-serif', 'color' => '#c2d5eb'),
			'type' => 'typography',
			'options' => array(
			'faces' => $typography_mixed_fonts,
			'styles' => false )
			  );
		$options[] = array('name' => __('Page Menu Active Color', 'singlepage'),'id' => 'home_nav_menu_hover_color' ,'std' => '#ffffff','type'=> 'color');
		
		$options[] = array( 'name' => __('Blog Menu Typography', 'singlepage'),

			'desc' => __('Blog Menu Typography.', 'singlepage'),
			'id' => 'blog_menu_typography',
			'std' => array( 'size' => '14px', 'face' => 'Open Sans, sans-serif', 'color' => '#666666'),
			'type' => 'typography',
			'options' => array(
			'faces' => $typography_mixed_fonts,
			'styles' => false )
			  );
		
		$options[] = array('name' => __('Blog Menu Active Color', 'singlepage'),'id' => 'blog_menu_hover_color' ,'std' => '#eeee22','type'=> 'color');
		
		$options[] = array( 'name' => __('Homepage Sidebar Menu Typography', 'singlepage'),

			'id' => 'homepage_side_nav_menu_typography',
			'std' => array( 'size' => '14px', 'face' => 'Open Sans, sans-serif', 'color' => '#dcecff'),
			'type' => 'typography',
			'options' => array(
			'faces' => $typography_mixed_fonts,
			'styles' => false )
			  );
	     $options[] = array('name' => __('Sidebar Menu Active Color', 'singlepage'),'id' => 'home_side_nav_menu_active_color' ,'std' => '#23dd91','type'=> 'color');
		 
		 $options[] = array(
		'name' => __('Side Nav Circle Color', 'singlepage'),
		'desc' => '',
		'id' => "home_side_nav_circle_color",
		'std' => "nav_cur0",
		'type' => "images",
		'options' => array(
			'nav_cur0' => $imagepath . 'nav_cur0.png',
			'nav_cur1' => $imagepath . 'nav_cur1.png',
			'nav_cur2' => $imagepath . 'nav_cur2.png',
			'nav_cur3' => $imagepath . 'nav_cur3.png',
			'nav_cur4' => $imagepath . 'nav_cur4.png',
			'nav_cur5' => $imagepath . 'nav_cur5.png',
			'nav_cur6' => $imagepath . 'nav_cur6.png',
			'nav_cur7' => $imagepath . 'nav_cur7.png',
			'nav_cur8' => $imagepath . 'nav_cur8.png',
			'nav_cur9' => $imagepath . 'nav_cur9.png',
			'nav_cur10' => $imagepath . 'nav_cur10.png',
			'nav_cur10' => $imagepath . 'nav_cur11.png',
		)
	);
		 
		 	 $options[] = array(
		'name' => __('Custom Side Nav Circle Image', 'singlepage'),
		'id' => 'home_side_nav_circle_image',
		'desc' => __('Circular png image with a 21 pixel radius.', 'singlepage'),
		'std' => '',
		'type' => 'upload');
        
       
		 
		 $options[] = array('name' => __('Sidebar Menu Background Color', 'singlepage'),'id' => 'home_side_nav_background_color' ,'std' => '','type'=> 'color');
		 
		 $options[] = array(
		'name' => __('Sidebar Menu Background Opacity', 'singlepage'),
		'desc' => '',
		'id' => 'home_side_nav_background_opacity',
		'type' => 'select',
		'class' => 'mini',
		'std' => '0.5',
		'options' => array_combine(range(0,1,0.1), range(0,1,0.1)) );
		 $options[] = array('name' => __('Sidebar Menu Border Radius', 'singlepage'),'class'=>'mini','id' => 'sidebar_menu_border_radius','type' => 'text','std'=>'0px','desc'=> '');
		 
		  $options[] = array( 'name' => __('Pages & Posts & Product Title Typography', 'singlepage'),

			'id' => 'page_post_title_typography',
			'std' => array( 'size' => '24px', 'face' => 'Open Sans, sans-serif', 'color' => '#555'),
			'type' => 'typography',
			'options' => array(
			'faces' => $typography_mixed_fonts,
			'styles' => false )
			  );
		  
		 $options[] = array( 'name' => __('Pages & Posts Content Typography', 'singlepage'),

			'id' => 'page_post_content_typography',
			'std' => array( 'size' => '14px', 'face' => 'Open Sans, sans-serif', 'color' => '#555'),
			'type' => 'typography',
			'options' => array(
			'faces' => $typography_mixed_fonts,
			'styles' => false )
			  );
		 //blog
        $options[] = array('name' => __('Blog', 'singlepage'),'type' => 'heading');
		$options[] = array('name' => __('Hide Post Meta', 'singlepage'),'std' => 'no','desc'=>__('Hide date, author, category...below blog title.','singlepage'),'id' => 'hide_post_meta',
		'type' => 'select','class'=>'mini','options'=>array("no"=>"no","yes"=>"yes"));
		$options[] = array('name' => __('Blog Title Color', 'singlepage'),'id' => 'blog_title_color','std'=>'#666666' ,'type'=> 'color');
		
		// woocommerce
		$options[] = array('name' => __('Woocommerce', 'singlepage'),'type' => 'heading');
		
		$options[] = array('name' => __('Shop Page Items Number', 'singlepage'),'std'=>'12','id' => 'woocommerce_page_num','type' => 'text');
		$options[] = array(	'name' => __('Enable Cart on Menu Area', 'singlepage'),'id' => 'woocommerce_cart_enable','std' => 'off','class' => 'mini','options' => array('off'=>'off','on'=>'on'),'type' => 'select');
		
		
		$options[] = array('name' => __('Autoupdate Config', 'singlepage'),'type' => 'heading');
     	$options[] = array('name' => __('HooThemes Register Email', 'singlepage'),'class'=>'mini','id' => 'hoothemes_email','type' => 'text','std'=>'','desc'=>'', 'singlepage');
        $options[] = array('name' => __('HooThemes License Key', 'singlepage'),'class'=>'mini','id' => 'hoothemes_license_key','type' => 'text','std'=>'','desc'=>'', 'singlepage');
		
		$options[] = array('name' => __('Export/Import', 'singlepage'),'type' => 'heading');
		
		$options[] = array(
		'name' => '',
		'desc' => '<h3>'.__('Demo Import', 'singlepage').'</h3><p>'.__('WARNING: Importing demo content will give you sliders, pages, posts, theme options and other settings. This will replicate the live demo. Clicking this option will replace your current theme options. It can also take a minute to complete.','singlepage').'</p><p><input name="fetch_attachments" id="fetch_attachments" type="checkbox" value="1" /> '.__('Download and import file attachments ( Memory Limit of 256 MB and max execution time (php time limit) of 300 seconds. ).', 'singlepage').'</p> <p><a id="import-demo" class="button-secondary"> '.__('Import Demo', 'singlepage').'</a></p><img style="padding-left:15px;display:none;" class="import-loading" src="'. $imagepath.'ajax-loader.gif" /><p id="import-status" style="padding-left:15px"></p>',
		'id' => 'demo-import',
		'std' => '',
		'type' => 'info');
		
		
		$options[] = array(
		'name' => '',
		'desc' => '<h3>'.__('Options Export', 'singlepage').'</h3><p>'.__( 'Export your Settings by highlighting this text and doing a copy/paste into a blank .txt file. Then save the file for importing into another install of WordPress later. Alternatively, you could just paste it into the <code>Appearance -> Theme Options -> Options Export/Import -> Options Import</code> <strong>Settings</strong> textarea on another web site.', 'singlepage' ).'</p><textarea readonly  name="export_settings" id="export_settings" cols="80" rows="10">'.$theme_options_export.'</textarea>',
		'id' => 'option-export',
		'std' => '',
		'type' => 'info');
		
		$options[] = array(
		'name' => '',
		'desc' => '<h3>'.__('Options Import', 'singlepage' ).'</h3><p>'.__( 'To import your Theme Options copy and paste what appears to be a random string of alpha numeric characters into this textarea and press the "Import Theme Options" button.', 'singlepage' ).'</p><textarea  cols="80" rows="10" name="import_data" id="import_data" class="textarea"></textarea><p><input type="button" style="float:left;" class="button-secondary" id="import-options" name="import" value="'.__('Import Theme Options', 'singlepage' ).'"></p>',
		'id' => 'option-import',
		'std' => '',
		'type' => 'info');
		
		
		
		$options[] = array('name' => __('ChangeLog', 'singlepage'),'type' => 'heading');
		
		include_once( ABSPATH . WPINC . '/feed.php' );
		$rss = fetch_feed( 'https://www.hoothemes.com/singlepage-pro-changelog/feed/' );
		
		$maxitems = 0;
		if ( ! is_wp_error( $rss ) ) : 
			$maxitems = $rss->get_item_quantity( 10 ); 
			$rss_items = $rss->get_items( 0, $maxitems );
		endif;
		$changelog = '<h2> '. __('Current Version', 'singlepage').': '.$theme_info->get( 'Version' ).' </h2>';
		$changelog .= '<ul>';
			 if ( $maxitems == 0 ) : 
		$changelog .= '<li>'. __( 'No items', 'singlepage' ).'</li>';
			  else :  
			  
				 foreach ( $rss_items as $item ) : 
				   $changelog .= '<li><h3>'.esc_html( $item->get_title() ).'</h3>'.$item->get_content().'</li>';
				endforeach;
			 endif; 
		$changelog .= '</ul>';


		$options[] = array(
		'name' => '',
		'desc' => $changelog,
		'id' => 'changelog',
		'std' => '',
		'type' => 'info');
		
	
	return $options;
}