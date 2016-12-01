<?php
class Hoo_Singlepage_slider {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'hoo_attr_singlepage_slider-shortcode', array( $this, 'attr' ) );

		add_shortcode('singlepage_slider', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {

		$defaults =	HooCore_Plugin::set_shortcode_defaults(
			array(
				'class'			=> '',
				'id'			=> '',
				'height'        =>'0'

			), $args
		);

		extract( $defaults );

		self::$args = $defaults;
		$custom    = get_post_meta( $id );
		$html      = '';
		$slider_id = uniqid('singlepage_slider_');
		$fullwidth = (isset($custom['fullwidth'][0]))?$custom['fullwidth'][0]:0;
		
		if( $fullwidth == '1' )
		$html .= '<div class="full_width_singlepage_slider_wrapper singlepage_slider_shortcode" style="position: relative;width: 100%;height: auto;margin-top: 0px;margin-bottom: 0px;">';
		else
		$html .= '<div class="singlepage_slider_shortcode">';
		$imagepath =  get_template_directory_uri() . '/images/';
		
		$html .= '<section class="section '.esc_attr($class).'">';
		$html .= '<div class="controls"><a href="javascript:;" class="singlepage_slider_arrow_left"  id="prev_'.$slider_id.'"><img src="'.$imagepath.'large_arrow_left.png" alt="'.__( 'Slide Left', 'singlepage' ).'" /></a>
		<a href="javascript:;" id="next_'.$slider_id.'" class="singlepage_slider_arrow_right"><img src="'.$imagepath.'large_arrow_right.png" alt="'.__( 'Slide Right', 'singlepage' ).'" /></a></div>
		<img class="cycle-loader" src="'.$imagepath.'ajax-loader.gif" />';
		
		
	    $slider = array();
	    if(isset($custom["singlepage_slider"][0]))
	    $slider = unserialize( base64_decode($custom["singlepage_slider"][0]) );
		$slider = stripslashes_deep( $slider );
		
		$timeout = 0;
       if(isset( $custom['autoplay'][0]) && $custom['autoplay'][0] == '1')
       $timeout = (isset($custom['timeout'][0]) && is_numeric($custom['timeout'][0]))?$custom['timeout'][0]:4000;
	   
		if( count($slider)>0 ){
			$html .= '<div class="singlepage_slider" data-height="'.$height.'" data-cycle-timeout='.$timeout.' data-cycle-slides=">div" id="'.$slider_id.'" data-cycle-prev="#prev_'.$slider_id.'" data-cycle-next="#next_'.$slider_id.'">';
		foreach( $slider as $slide ){
			
			$content_typography = singlepage_get_typography( $slide['content_typography'] );
			
			
			 switch( $slide['slide_type'] ){
				 case "image":
				$html .= '<div>
				<img src="'.$slide['image'].'" alt="" />
				<div class="in-slide-content" style="display:none;'.$content_typography.'">
					'.do_shortcode( $slide['slide_content'] ).'
				</div>
			</div>';
				 break;
				 case "iframe":
				$html .= '<div class="video">
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
				$html .= '<div class="video">
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
			$html .= '</div>';
		}

		$html .= '<script>jQuery(document).ready(function($) {
									
				$("#'.$slider_id.'").maximage({
					cycleOptions: {
						fx: "fade",
						speed: 500,
						pauseOnHover:true,
						loop:0,
						autoSelector:"#'.$slider_id.'",
			
					},
					onFirstImageLoaded: function(){
						jQuery(".cycle-loader").hide();
						jQuery(".singlepage_slider").fadeIn("fast");
						if(jQuery("#'.$slider_id.' .mc-image:first-child").find("video").length > 0){
						jQuery("#'.$slider_id.' .mc-image:first-child").find("video")[0].play();
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
								// Pauses HTML5 video when you leave it
								
									if($(outgoingSlideEl).find("video").length > 0) $(outgoingSlideEl).find("video")[0].pause();
										
								
							}
});
	
				// Helper function to Fill and Center the HTML5 Video
				$("video,object").maximage("maxcover");
	
				// To show it is dynamic html text
				$(".in-slide-content").delay(1200).fadeIn();
				});
</script>';
		$html .= '</section>';
		//	if( $fullwidth == '1' )
		$html .= '<div class="singlepage-slider-fullwidth-forcer" style="width: 100%;"></div></div>';
		

		return $html;

	}

	function attr() {

		$attr = array();

		$attr['class'] = 'singlepage-slider slider';

		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class'];
		}

		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id'];
		}

		return $attr;

	}
	

}

new Hoo_Singlepage_slider();