<?php
class Hoo_Progress {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode('progress_old', array( $this, 'render' ) );

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
					
				'percent' 	=> 'percent',
				'id' =>'',
				'class' =>''
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		$percent = absint($percent);
		
		$html = '<div id="'.esc_attr($id).'" class="singlepage-progress progress-bar default '.esc_attr($class).'" data-percent="'.$percent.'"><div></div></div>';

		return $html;

	}


}

new Hoo_Progress();