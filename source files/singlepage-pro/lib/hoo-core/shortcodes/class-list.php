<?php
class Hoo_List {

	public static $args;
    private  $border_style;
	private  $font_size;
	private  $icon;
	private  $icon_color;
	private  $animation_type;
	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'list', array( $this, 'render_parent' ) );
        add_shortcode( 'list_item', array( $this, 'render_child' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render_parent( $args, $content = '') {

		$defaults =	HooCore_Plugin::set_shortcode_defaults(
			array(
				  'icon_color' =>'',
				  'icon'=>'fa-check',
				  'font_size'=>'16',
                  'border' => '0',
				  'animation_type' => '',
			  	  'id' =>'singlepage-list',
				  'class' =>''
			), $args
		);
        
		extract( $defaults );
		self::$args = $defaults;
			
	   $border_style = " list-border-none";
	   if( $border == "1")
	   $border_style = " list-border";
	   
	   $class   .= $border_style;
	   $font_size = absint( $font_size );
	   
	   $this->border_style = $border_style;
	   $this->font_size = $font_size;
	   $this->icon = $icon;
	   $this->icon_color = $icon_color;
	   $this->animation_type = $animation_type;
   
   $html    = '<ul class="singlepage-shortcode shortcode-list list-style-1 '.esc_attr($class).'" id="'.esc_attr($id).'">'.do_shortcode( singlepage_fix_shortcodes($content)).'</ul>';

		return $html;

	}
	
	/**
	 * Render the child shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render_child( $args, $content = '') {
		
		$defaults =	HooCore_Plugin::set_shortcode_defaults(
			array(), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		
		$css_class  = "";
		$icon_color = "";
		if( $this->animation_type != "" )
		$css_class  .= "wow ".$this->animation_type;
		if( $this->border_style != "" )
		$css_class  .= " ".$this->border_style;
		if(  $this->icon_color != "" ){
			$icon_color = "color:".$this->icon_color.";";
			}

         $html ='<li style="font-size:'.$this->font_size.'px" class="'.$css_class.'"><i style="'.$icon_color.'" class="fa '.$this->icon.'"></i>'.do_shortcode( singlepage_fix_shortcodes($content) ).'</li>';

		return $html;
	}


}

new Hoo_List();