<?php
class Hoo_Column {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode('column', array( $this, 'render' ) );

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
				'col_xs' => '',
				'col_sm' => '',
				'col_md' => '',
				'col_lg' => '',
				'id' =>'',
				'class' =>''
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		
		$col_class = "";
  if(trim($col_xs) != "" && is_numeric($col_xs)){  $col_class .= "col-xs-".$col_xs." ";}
  if(trim($col_sm) != "" && is_numeric($col_sm)){  $col_class .= "col-sm-".$col_sm." ";}
  if(trim($col_md) != "" && is_numeric($col_md)){  $col_class .= "col-md-".$col_md." ";}
  if(trim($col_lg) != "" && is_numeric($col_lg)){  $col_class .= "col-lg-".$col_lg." ";}
  
  if(trim($class) != ""){  $col_class .= $class;}
  
  $html  = '<div id="'.$id.'" class="singlepage-shortcode singlepage-column '.$col_class.'">';
  $html .= do_shortcode(singlepage_fix_shortcodes( $content) );
  $html .= '<div class="clear"></div>';
  $html .= '</div>';

		return $html;

	}


}

new Hoo_Column();