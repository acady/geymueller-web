<?php
class Hoo_Fact {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode('fact', array( $this, 'render' ) );
		add_shortcode('counter', array( $this, 'render' ) );

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
					
				'num' 	=> '50',
				'name' =>'',
				'id' =>'',
				'class' =>''
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		$num = absint($num);
		
		$html = '<span id="'.esc_attr($id).'" class="singlepage-fact fact wow rotateIn '.esc_attr($class).'" data-fact="'.$num.'">0</span><div
class="fact-name wow fadeInUp">'.esc_attr($name).'</div>';

		return $html;

	}


}

new Hoo_Fact();