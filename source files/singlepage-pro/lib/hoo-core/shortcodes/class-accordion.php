<?php
class Hoo_Accordion {

	public static $args;
    private  $id;
	private  $num;
	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'accordion', array( $this, 'render_parent' ) );
        add_shortcode( 'accordion_item', array( $this, 'render_child' ) );
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
				'id' =>'singlepage-accordion',
				'class' =>''
			), $args
		);
        
		extract( $defaults );
		self::$args = $defaults;
		$this->id = $id;
        $this->num = 1;
		$html = '<div class="singlepage-shortcode singlepage-accordion accordion '.esc_attr($class).'" id="'.esc_attr($id).'">'.do_shortcode( singlepage_fix_shortcodes($content)).'</div>';

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
				'status' =>'',
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;

		if( $status == "open" ) 
		$status = "in";
		else
		$status = "";
		
        $itemId = $this->id."-".$this->num;
         $html ='<div class="accordion-group">
          <div class="accordion-heading">
           <a class="accordion-toggle" data-toggle="collapse" data-parent="#'.$this->id.'" href="#'.$itemId.'">'.esc_attr($title).'</a>
           </div>
        <div id="'.$itemId.'" class="accordion-body collapse '.$status.'">
      <div class="accordion-inner">
      <p>'.do_shortcode( singlepage_fix_shortcodes($content)).'</p>
    </div>
    </div>
</div>';
$this->num++;
		return $html;
	}


}

new Hoo_Accordion();