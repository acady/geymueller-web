<?php
class Hoo_Service {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode('service', array( $this, 'render' ) );

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
				'title'			=> '',
				'icon'			=> '',
				'icon_color'	=> '',				
				'link' 	=> '',
				'class' =>'',
				'id' =>'',
				'icon_animation_type' =>'',
				'title_animation_type' =>'',
				'content_animation_type' =>'',
				'animation_duration' =>''
			), $args
		);

		extract( $defaults );

		self::$args = $defaults;
		
		if( $icon_animation_type != "" )
		$icon_animation_type = "wow ".$icon_animation_type;
		if( $title_animation_type != "" )
		$title_animation_type = "wow ".$title_animation_type;
		if( $icon_animation_type != "" )
		$content_animation_type = "wow ".$content_animation_type;
		
		if( $animation_duration != "" )
		$animation_duration = "data-animationduration='".$animation_duration."'";
     
    if($icon_color != "")
    $icon_color = 'style="color:'.$icon_color.'"';
   
   $html   = '<div id="'.$id.'" class="singlepage-shortcode  singlepage-service service-box text-center '.$class.'">';
   if($icon != "")
   $html  .= '<i class="fa '.$icon.' '.$icon_animation_type.'" '.$icon_color.' '.$animation_duration.'> </i>';
   if($title != "")
   $html  .= '<h3 class="'.$title_animation_type.'" '.$animation_duration.'>'.$title.'</h3>';
   $html  .= '<div class="'.$content_animation_type.'" '.$animation_duration.'><p>'.do_shortcode(singlepage_fix_shortcodes( $content) ).'</p>';
   if($link != "")
   $html  .= '<a href="'.esc_url($link).'">'.__("Read More","singlepage").'&gt;&gt;</a>';
   
   $html  .= '</div></div>';

		return $html;

	}


}

new Hoo_Service();