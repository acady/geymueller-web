<?php
/**
 * Template Name: Home Page
 *
 * @since SinglePage 2.3.4
 */
     get_header("featured");
     global $allowedposttags;
	 
	  $allowedposttags['iframe'] = array(
	  'align' => true,
	  'width' => true,
	  'height' => true,
	  'frameborder' => true,
	  'name' => true,
	  'src' => true,
	  'id' => true,
	  'class' => true,
	  'style' => true,
	  'scrolling' => true,
	  'marginwidth' => true,
	  'marginheight' => true,
	  
	  );
	 $detect                     = new Mobile_Detect;
     $sectionNum                 = of_get_option('section_num', 4);
	 $hide_scroll_bar            = of_get_option('hide_scroll_bar', 0);
	 $section_height_mode        = of_get_option('section_height_mode', 1);
     $section_menu_title         = array("SECTION ONE","SECTION TWO","SECTION THREE","SECTION FOUR","","","","","","");
	 $section_menu_slug          = array("section-one","section-two","section-three","section-four","","","","","","");
	 $section_content_color      = array("#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff","#ffffff");
	 $section_css_class          = array("","","","","","","","","","");
	 $section_background_size    = array("yes","no","no","yes","","","","","","");
	 $imagepath =  get_template_directory_uri() . '/images/';
	 
	 $video_background_section  = of_get_option( 'video_background_section',0);
	  $mp4_video_url       = esc_url( of_get_option( 'mp4_video_url' ) );
	  $ogv_video_url       = esc_url( of_get_option( 'ogv_video_url' ));
	  $webm_video_url      = esc_url( of_get_option( 'webm_video_url' ));
	  $poster_url          = esc_url( of_get_option( 'poster_url' ));
	  $video_loop          = esc_attr( of_get_option( 'video_loop' ));
	  $video_volume        = esc_attr( of_get_option( 'video_volume' ));
	  $video_volume        = $video_volume == "" ? 0.8 : $video_volume ;
	  $display_buttons     = absint( of_get_option( 'display_buttons',1 ));
	  $autoplay            = absint( of_get_option( 'autoplay',1 ));
	  
	  $google_map_section  = of_get_option( 'google_map_section',0);
	  $google_map_address  = esc_attr( of_get_option( 'google_map_address','Sydney, NSW'));
	  $google_map_zoom     = absint( of_get_option( 'google_map_zoom',10));
	  
	  $menu_style_desktop   = absint( of_get_option( 'menu_style_desktop',1));
	  $menu_status_desktop  = esc_attr( of_get_option( 'menu_status_desktop','open'));
	  $menu_style_tablet    = absint( of_get_option( 'menu_style_tablet',1));
	  $menu_status_tablet   = esc_attr( of_get_option( 'menu_status_tablet','open'));
	  $menu_style_mobile    = absint( of_get_option( 'menu_style_mobile',2));
	  $menu_status_mobile   = esc_attr( of_get_option( 'menu_status_mobile','close'));
	  
	  $menu_style   = $menu_style_desktop;
	  $menu_status  = $menu_status_desktop;
	  
	  if( $detect->isTablet() ){
         $menu_style  = $menu_style_tablet;
		 $menu_status = $menu_status_tablet;
	   }
	  if( $detect->isMobile() && !$detect->isTablet() ){
		 $menu_style  = $menu_style_mobile;
		 $menu_status = $menu_status_mobile;
	  }
	  
	  
	 $section_background = array(
	     array(
		'color' => '',
		'image' => $imagepath.'bg_01.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' ),
		 array(
		'color' => '',
		'image' => $imagepath.'bg_02.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' ),
		 array(
		'color' => '',
		'image' => $imagepath.'bg_03.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' ),
		 array(
		'color' => '',
		'image' => $imagepath.'bg_04.jpg',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' ),
		  array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' )
		  ,
		   array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' ),
		    array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' )
			,
			 array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' ),
			 array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' ),
			 array(
		'color' => '#006621',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'fixed' )
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
</p>',"","","","","","" );
  $output                   = "";
  $sub_nav                  = "";
  
		if(  $sectionNum > 0 ) { 
		    for( $i=0; $i<$sectionNum; $i++ ){
			
	$section_full_width =  of_get_option('section_full_width_'.$i, 0 );	
	$menu_title        =  of_get_option('section_menu_title_'.$i, $section_menu_title[$i] );
	$menu_slug         =  of_get_option('section_menu_slug_'.$i, $section_menu_slug[$i] );
	if( !$menu_slug )
	$menu_slug         =  'section-'.($i+1);
	$target            =  of_get_option('section_link_target_'.$i, '_blank');
	$menu_slug         = sanitize_title($menu_slug );
	$class             =  of_get_option('section_css_class_'.$i, $section_css_class[$i]) ;
	$image  	       =  of_get_option('section_image_'.$i, $section_image[$i]) ;
	$image_link        =  of_get_option('section_image_link_'.$i, '') ;
	$image_link_target =  of_get_option('section_image_link_target_'.$i,'') ;
	
	$content	               = of_get_option('section_content_'.$i, $section_content[$i]);
	$content_color             = of_get_option('section_content_color_'.$i, $section_content_color[$i]) ;
	$section_background_       = of_get_option( 'section_background_'.$i,$section_background[$i]);
    $background                = singlepage_get_background( $section_background_ );
	
	// background for mobile & menu styles
		
	$background_tablet         = singlepage_get_background( of_get_option( 'section_background_tablet_'.$i,'') );
	$background_mobile         = singlepage_get_background( of_get_option( 'section_background_mobile_'.$i,'') );
	

	if( $detect->isTablet() && $background_tablet ){
       $background             = $background_tablet;
     }
	if( $detect->isMobile() && !$detect->isTablet() && $background_mobile ){
       $background             = $background_mobile;
    }
	
    $section_background_size_  = of_get_option( 'background_size_'.$i, $section_background_size[$i] );
	$section_type              = of_get_option( 'section_type_'.$i, 'content' );
	$section_slider            = of_get_option( 'section_slider_'.$i, 0 );
	$section_menu_link         = esc_url(of_get_option( 'section_menu_link_'.$i, '' ));
	
	$content_style              = '';
	$section_content_background =  of_get_option( 'section_content_background_'.$i,'');
	$border_radius	            =  of_get_option('border_radius_'.$i, '0');
	$opacity    	            =  of_get_option('opacity_'.$i, '1');
	
	$uniq_class                 = uniqid('section-');
	$class                     .= ' '.$uniq_class;
	
	$class                     .= ' home_section_'.($i+1);
	
	if( $section_content_background ){
		$rgb = singlepage_hex2rgb( $section_content_background );
	    $content_style .= "background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",".$opacity.");";
		$content_style .= 'border-radius: '.$border_radius.';-moz-border-radius: '.$border_radius.';-webkit-border-radius: '.$border_radius.';';
	}
	
	$section_content_typography       = of_get_option("section_content_typography_".$i,'');
	if( $section_content_typography )
	$content_style     .= singlepage_options_typography_font_styles2( $section_content_typography );
	
	if(function_exists('Form_maker_fornt_end_main')){
							$content = Form_maker_fornt_end_main($content);
							}
	
	$cur  = "";
	if( $i==0 )
	$cur  = "cur";
	
	if( $section_type == 'link'){
		$sub_nav       .= '<li class="'.$cur.'"><a id="nav-'.$menu_slug.'" target="'.$target.'" href="'.$section_menu_link.'">'.esc_attr($menu_title).'</a></li>';
	}else{
	    $sub_nav       .= '<li class="'.$cur.'"><a id="nav-'.$menu_slug.'" href="#'.$menu_slug.'">'.esc_attr($menu_title).'</a></li>';
	}

			if( $section_background_size_ == 'yes'){
				 $background .= '-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-size:100% 100%;';
				}
				
		 $video_enable = 0;
	  
	  if(  $video_background_section == ($i+1) /*&& !$detect->isMobile() && !$detect->isTablet()*/ ){
		$video_enable = 1;  
		$class       .= " singlepage-video-section";
		$background   = "";
	  }
	  if( $google_map_section == ($i+1) ){
		  
		  
		$class       .= " singlepage-google-map-section";
	    $google_map   = array(
							  "google_map_address"=>$google_map_address,
							  "google_map_zoom"=>$google_map_zoom,
							  "google_map_wrap"=>$menu_slug,
							  'start'        =>  esc_attr(of_get_option('google_map_start', '')),
							  'end' => esc_attr(of_get_option('google_map_end', '')),
							  'traffic' => esc_attr(of_get_option('google_map_traffic', 'yes')),
							  'bike'=> esc_attr(of_get_option('google_map_bike', 'no')),
							  'scrollwheel' => esc_attr(of_get_option('google_map_scrollwheel', 'false')),
							  'scale' => esc_attr(of_get_option('google_map_scale', 'false')),
							  'infowindow'=>of_get_option('google_map_infowindow', ''),
							  'icon'=> esc_attr( of_get_option('google_map_icon', '') )
							  
							  
							  );
	    wp_localize_script( 'singlepage-main', 'singlepage_google_map',$google_map);
		$background   = "";
		  
		  }
		
		
/*		if( $container_width  != "" ) $content_style .= 'width:'.esc_attr($container_width).';';
		if( $container_left  != "" ) $content_style .= 'left:'.esc_attr($container_left).';';
		if( $container_top  != "" ) $content_style .= 'top:'.esc_attr($container_top).';';
		if( $container_padding  != "" ) $content_style .= 'padding:'.esc_attr($container_padding).';';*/

	if( $section_type == 'slider' && $section_slider > 0 ){
		$slider_id = uniqid('singlepage_slider_');
		
		$output .= '<section class="section '.esc_attr($class).'" id="'.$menu_slug.'">';
		
			
		$output .= '<div class="singlepage-slider-wrapper"><div class="controls"><a href="javascript:;" id="prev_'.$slider_id.'" class="singlepage_slider_arrow_left"><img src="'.$imagepath.'large_arrow_left.png" alt="'.__( 'Slide Left', 'singlepage' ).'" /></a>
		<a href="javascript:;" id="next_'.$slider_id.'" class="singlepage_slider_arrow_right"><img src="'.$imagepath.'large_arrow_right.png" alt="'.__( 'Slide Right', 'singlepage' ).'" /></a></div>
		<img class="cycle-loader" src="'.$imagepath.'ajax-loader.gif" />';
		
		$custom    = get_post_meta($section_slider);
	    $slider    = array();
		
	    if( isset($custom["singlepage_slider"][0]) )
	    $slider = unserialize( base64_decode($custom["singlepage_slider"][0]) );
		
		$timeout = 0;
       if(isset( $custom['autoplay'][0]) && $custom['autoplay'][0] == '1')
       $timeout = (isset($custom['timeout'][0]) && is_numeric($custom['timeout'][0]))?$custom['timeout'][0]:4000;

		$slider = stripslashes_deep( $slider );
		if( count($slider)>0 ){
			$output .= '<div class="singlepage_slider" data-cycle-timeout='.$timeout.' data-cycle-slides=">div" id="'.$slider_id.'" data-cycle-prev="#prev_'.$slider_id.'" data-cycle-next="#next_'.$slider_id.'">';
		foreach( $slider as $slide ){
			
			$content_typography = singlepage_get_typography( $slide['content_typography'] );
			
			
			 switch( $slide['slide_type'] ){
				 case "image":
				$output .= '<div>
				<img src="'.$slide['image'].'" alt="" />
				<div class="in-slide-content" style="display:none;'.$content_typography.'">
					'.do_shortcode( $slide['slide_content'] ).'
				</div>
			</div>';
				 break;
				 case "iframe":
				$output .= '<div class="video">
				<img src="'.$slide['pattern'].'" alt="" />
				<iframe width="100%" height="100%" src="'.$slide['iframe'].'" frameborder="0" class="youtube-video" allowfullscreen></iframe>
			</div>';
				 break;
				 
				  case "html5_video":
				$loop = "";
				if( isset($slide['loop']) && $slide['loop'] == "on" ){
					$loop = 'loop="loop"';
					}
					$volume =  isset($slide['volume'])?$slide['volume']:'0.5';
				if( $volume == 0 ){
					$volume = '0.001';
					}
				$output .= '<div class="video">
					<img src="'.$slide['poster'].'" alt="" />
				<div class="in-slide-content light-text smaller-text" style="'.$content_typography.'">
					'.do_shortcode($slide['slide_content']).'
				</div>	
				<video controls="controls" data-volume="'.$volume.'" poster="'.$slide['poster'].'" '.$loop.'  preload="none" width="640" height="360">
					<source src="'.$slide['mp4'].'" type="video/mp4" />
					<source src="'.$slide['webm'].'" type="video/webm" />
					<source src="'.$slide['ogg'].'" type="video/ogg" />
				</video>
			</div>';
				 break;
				 
				 }
			}
			$output .= '</div></div>';
		}



$output .= '<script>jQuery(document).ready(function($) {
				$("#'.$slider_id.'").maximage({
					cycleOptions: {
						fx: "fade",
						speed: 500,
						pauseOnHover:true,
						loop:0,
						autoSelector:"#'.$slider_id.'",
					},
					onFirstImageLoaded: function(){
						$(".cycle-loader").hide();
						$(".singlepage_slider").fadeIn("fast");
						if($("#'.$slider_id.' .mc-image:first-child").find("video").length > 0){
						$("#'.$slider_id.' .mc-image:first-child").find("video")[0].play();
						}
						
					}
				});
				
				$("#'.$slider_id.'").on( "cycle-before", function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
    if(!$.browser.msie){
					if($(incomingSlideEl).find("video").length > 0) {
									var volume = $(incomingSlideEl).find("video").data("volume"); 
									$(incomingSlideEl).find("video")[0].play();
									$(incomingSlideEl).find("video").prop("volume", volume);
									}
								 
							}
});
				
 $("#'.$slider_id.'").on( "cycle-after", function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
   if(!$.browser.msie){
									if($(outgoingSlideEl).find("video").length > 0) $(outgoingSlideEl).find("video")[0].pause();								
							}
});

				$("video,object").maximage("maxcover");
				$(".in-slide-content").delay(1200).fadeIn();
				});
</script>';
				
				
		$output .= '</section>';
		
		}
	if( $section_type == 'content' || $section_type == 'link' ){
		 if( $section_full_width == 1){
			 $output .= '<section class="section '.esc_attr($class).'" style="'.$background.'" id="'.$menu_slug.'">';
			 		
			$output .= '<div class="section-full-content" style="'.str_replace('"','\'',$content_style).'">'.do_shortcode( $content ).'</div>';
		
		if( $image!='' ){
			if( $image_link !='' ){
				$output .= '<a href="'.esc_url($image_link).'" style=" display:black;" target="'.esc_attr($image_link_target).'"><div class="section-image" style="background-image:url('.esc_url($image).')"></div></a>';
				}else{
	 	        $output .= '<div class="section-image" style="background-image:url('.esc_url($image).')"></div>';
			}
		}
		
		
		$output .= '</div><div class="clear"></div></section>';
			 
			 }else{	
			
       $output .= '<section class="section '.esc_attr($class).'" style="'.$background.'" id="'.$menu_slug.'">';
			
	   $output .= ' <div class="container">
		<div class="section-inner">
			<div class="section-content" style="'.str_replace('"','\'',$content_style).'">'.add_geymueller_highlights(do_shortcode( $content )).'</div>';

		if( $image!='' ){
			if( $image_link !='' ){
				$output .= '<a href="'.esc_url($image_link).'" style=" display:black;" target="'.esc_attr($image_link_target).'"><div class="section-image" style="background-image:url('.esc_url($image).')"></div></a>';
				}else{
	 	        $output .= '<div class="section-image" style="background-image:url('.esc_url($image).')"></div>';
			}
		}
		
		
		$output .= '</div>
		  <div class="clear"></div>
		</div>
        </section>';
		 }
		
		
		  if( $video_enable == 1 ){
		 
		 if( $video_loop == 1 ){
		$video_loop = 'true';
		}
		else{
		$video_loop = 'false';	
		}
	 
	// $background_video  = array("video_loop"=>$video_loop,"mp4_video_url"=>$mp4_video_url,"webm_video_url"=>$webm_video_url,"ogv_video_url"=>$ogv_video_url,'poster_url'=>$poster_url,'video_volume' => $video_volume);
	
	//  wp_localize_script( 'singlepage-main', 'singlepage_video',$background_video);
	  
	  $background_video   = array("mp4_video_url"=>$mp4_video_url,"webm_video_url"=>$webm_video_url,"ogv_video_url"=>$ogv_video_url,"loop"=>$video_loop,"volume"=>$video_volume,"poster_url"=>$poster_url,"container"=>'.'.$uniq_class ,"volume"=>$video_volume,"autoplay"=>$autoplay,'display_buttons'=>$display_buttons);
	  
	    wp_localize_script( 'singlepage-videobackground', 'background_video',$background_video);
	    $background = "";
		if( $detect->isMobile() || $detect->isTablet() ){
		$play_button     = '<span class="play-video"><i class="fa fa-play-circle"></i></span>';  
		}
		
	 }
	 
   }
 }
 }
 ?>
<?php 
    if( $sectionNum > 1 && $menu_style == '1' && $menu_status == 'open' ){
 ?>

<div id="sub_nav" class="sub_nav_style1">
  <div id="sub_nav_<?php echo $section_height_mode;?>" class="sub_nav">
    <ul>
      <?php echo $sub_nav;?>
    </ul>
  </div>
</div>
<?php }?>
<?php if( $sectionNum > 1 && $menu_style == '2' ){
			$hide_sidebar = '';
			if( $menu_status == 'close')
			$hide_sidebar = 'hide-sidebar';
			?>
<div id="sub_nav" class="sub_nav_style2">
  <div id="sub_nav_<?php echo $section_height_mode;?>" class="sub_nav <?php echo $hide_sidebar;?>"> <span id="panel-cog"> <i class="fa fa-bars"></i> </span>
    <ul>
      <?php echo $sub_nav;?>
    </ul>
  </div>
</div>
<?php }?>
<?php
	$featured_homepage_sidebar = of_get_option( 'featured_homepage_sidebar' ,'' );
	if( $featured_homepage_sidebar != '' ){
		echo '<div class="widget"><div class="widget_area">'.do_shortcode( wp_kses( $featured_homepage_sidebar , $allowedposttags ) ).'</div></div>';
		}
      
 ?>
<div class="content"> <?php echo $output;?>
  <div class="clear"></div>
  <script>
    jQuery(document).ready(function($) {
      // load here instead of wp_enqueue (via https://stackoverflow.com/questions/11533168)
      $.getScript("<?=get_template_directory_uri()?>/js/jquery.easing.1.3.js");
    });
  </script>
</div>
<?php 
    $youtube_video_background_section = of_get_option( 'youtube_video_background_section' ,'0' );
	$youtube_video                    = of_get_option( 'youtube_video' ,'' );
	$youtube_video_loop               = of_get_option( 'youtube_video_loop' ,'true' );
	$youtube_video_mute               = of_get_option( 'youtube_video_mute' ,'true' );
	$youtube_show_controls            = of_get_option( 'youtube_show_controls' ,'true' );
	$youtube_start_at                 = absint(of_get_option( 'youtube_start_at' ,'0' ));
	$youtube_show_controls            = $youtube_show_controls ==''?'true':$youtube_show_controls ;
	
	if( $youtube_video_background_section > 0 && $youtube_video != '' ):
 ?>
<div id="home_youtube_video" class="player" data-property="{videoURL:'<?php echo $youtube_video;?>',containment:'.home_section_<?php echo $youtube_video_background_section;?>', showControls:<?php echo $youtube_show_controls;?>, autoPlay:true, loop:<?php echo $youtube_video_loop;?>, mute:<?php echo $youtube_video_mute;?>, startAt:<?php echo $youtube_start_at;?>, opacity:1, addRaster:true, quality:'default'}">&nbsp;</div>
<?php endif;?>
<?php
get_footer();