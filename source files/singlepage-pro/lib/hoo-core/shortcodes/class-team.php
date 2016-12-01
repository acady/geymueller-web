<?php
class Hoo_Team {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode('team', array( $this, 'render' ) );

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
					
				'avatar' => '',
				'name' =>'',
				'byline' =>'',
				'id' =>'',
				'class' =>''
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		
		if( $avatar != "" )
		$avatar = '<img src="'.esc_url($avatar).'">';
		$html = '<div class="singlepage-team team-member text-center">
    <div class="inner">
      <div class="inner-wrap">
      <div class="team-box-image">'.$avatar.'</div>
      <div class="team-box-text ">
          <h4 class="uppercase">'.esc_attr($name).'<br>
            <span class="thin-font">'.esc_attr($byline).'</span>
          </h4>
          <div class="show-next">
             <div class="tx-div small"></div>
        </div>
           <p></p><p>'.do_shortcode( singlepage_fix_shortcodes($content)).'</p><p></p>
      </div>
    </div>
  </div>
</div>';

		return $html;

	}


}

new Hoo_Team();