<?php
class Hoo_Alert {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode('alert', array( $this, 'render' ) );

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
					
				'type' 	=> 'info',
				'id' =>'',
				'class' =>''
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		switch($type){
			case "info":
			$icon = " fa fa-info-circle";
			$style = "alert-info alert-dismissable";
			break;
			case "success":
			$icon = " fa fa-check";
			$style = "alert-success alert-dismissable";
			break;
			case "error":
			$icon = " fa fa-remove";
			$style = "alert-danger alert-dismissable";
			break;
			case "warning":
			$icon = " fa fa-warning";
			$style = "alert-warning alert-dismissable";
			break;
			default:
			$icon = " fa fa-info-circle";
			$style = "alert-info alert-dismissable";
			break;
			
			}
		
		$html = '<div id="'.esc_attr($id).'" class="singlepage-shortcode singlepage-alert alert '.esc_attr($class).' '.$style.'"><a href="#" class="close" data-dismiss="alert">&times;</a><i class="'.$icon.'"></i> '.do_shortcode( singlepage_fix_shortcodes($content)).'</div>';

		return $html;

	}


}

new Hoo_Alert();