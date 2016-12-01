<?php
class Hoo_Progressbar {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'hoo_attr_progressbar-shortcode', array( $this, 'attr' ) );
		add_filter( 'hoo_attr_progressbar-shortcode-content', array( $this, 'content_attr' ) );
		add_filter( 'hoo_attr_progressbar-shortcode-span', array( $this, 'span_attr' ) );
		
		add_shortcode('progress', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $args, $content = '') {
		
		$defaults =	HooCore_Plugin::set_shortcode_defaults(
			array(
				'class'				=> '',
				'id'				=> '',
				'animated_stripes'	=> 'no',
				'filledcolor' 		=> '',
				'percentage'		=> '70',
				'striped'			=> 'no',
				'textcolor'			=> '',
				'unfilledcolor' 	=> '',
				'unit' 				=> '',
			), $args
		);

		extract( $defaults );

		self::$args = $defaults;

		if( ! $filledcolor ) {
			self::$args['filledcolor'] = '#ff8400';
		}
		
		if( ! $textcolor ) {
			self::$args['textcolor'] = '#ffffff';
		}		

		if( ! $unfilledcolor ) {
			self::$args['unfilledcolor'] = '#292929';
		}
		
		$html = sprintf( '<div %s><div %s></div><span %s>%s %s%s</span></div>', HooCore_Plugin::attributes( 'progressbar-shortcode' ), hooCore_Plugin::attributes( 'progressbar-shortcode-content' ),
						  hooCore_Plugin::attributes( 'progressbar-shortcode-span' ), $content, $percentage, $unit );

		return $html;

	}

	function attr() {
	
		$attr = array();
		
		$attr['style'] = sprintf( 'background-color:%s;', self::$args['unfilledcolor'] );

		$attr['class'] = 'hoo-progressbar progress-bar';
		
		if( self::$args['striped'] == "yes" ) {
			$attr['class'] .= ' progress-striped';
		}
		
		if( self::$args['animated_stripes'] == "yes" ) {
			$attr['class'] .= ' active';
		}			

		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class'];
		}

		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id'];
		}

		return $attr;

	}

	function content_attr() {
	
		$attr = array();

		$attr['class'] = 'progress progress-bar-content';
		
		$attr['style'] = sprintf( 'width:%s%%;background-color:%s;', 0, self::$args['filledcolor'] );

		$attr['role'] = 'progressbar';
		$attr['aria-valuemin'] = '0';
		$attr['aria-valuemax'] = '100';
		

		$attr['aria-valuenow'] = self::$args['percentage'];

		return $attr;

	}
	
	function span_attr() {
	
		$attr = array();

		$attr['class'] = 'progress-title sr-only';
		
		$attr['style'] = sprintf( 'color:%s;', self::$args['textcolor'] );

		return $attr;

	}	

}

new Hoo_Progressbar();