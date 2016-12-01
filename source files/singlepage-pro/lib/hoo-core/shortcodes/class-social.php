<?php
class Hoo_Social {

    public static $args;
	/**
	 * Initiate the shortcode
	 */

	
	public function __construct() {

        add_shortcode( 'social', array( $this, 'render_parent' ) );
        add_shortcode( 'social_icon', array( $this, 'render_child' ) );
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
				'id' => 'singlepage-social',
				'class' => ''
			), $args
		);
        
		extract( $defaults );
		
		self::$args = $defaults;
		
		$html = '<div class="singlepage-shortcode singlepage-social social-icons '.esc_attr($class).'" id="'.esc_attr($id).'">'.do_shortcode( singlepage_fix_shortcodes($content)).'</div>';

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
			array(
				'title' =>'',
				'link' =>'',
				'icon' =>'',
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		
        $html ='<a href="'.esc_url($link).'" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.esc_attr($title).'" target="_blank"><i class="fa '.esc_attr($icon).'"></i></a>';

		return $html;
	}


}

new Hoo_Social();