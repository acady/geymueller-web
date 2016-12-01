<?php
class Hoo_Button {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode('button', array( $this, 'render' ) );

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
				'color' => '',
				//'hover_color' => '',			
				'link' 	=> '',
				'target' =>'',
				'id' =>'',
				'class' =>'',
				'size' =>''
			), $args
		);

		extract( $defaults );

		self::$args = $defaults;
		
		$css_style  = "";
		if( $color != "")
		$css_style .= "background-color:".$color.";";
		
		$html = '<a href="'.esc_url($link).'" target="'.esc_attr($target).'" id="'.esc_attr($id).'" class="singlepage-shortcode singlepage-button button green '.esc_attr($size).' '.esc_attr($class).'" style="'.esc_attr($css_style).'";>'.esc_attr($content).'</a>';

		return $html;

	}


}

new Hoo_Button();