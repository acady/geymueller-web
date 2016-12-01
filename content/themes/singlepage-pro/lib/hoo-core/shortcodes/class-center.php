<?php
class Hoo_Center {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode('center', array( $this, 'render' ) );

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
					
				'id' =>'',
				'class' =>''
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;

		
		$html = '<div id="'.esc_attr($id).'" class="singlepage-center text-center '.esc_attr($class).'" >'.do_shortcode( singlepage_fix_shortcodes($content)).'</div>';

		return $html;

	}


}

new Hoo_Center();