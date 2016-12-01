<?php
class Hoo_Blog {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode('blog', array( $this, 'render' ) );

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
					
				'num' 	=> '10',
				'category' 	=> '',
				'id' =>'',
				'class' =>'',
				'page_nav'=>'yes'
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		 global $paged;
		 
    $html = '<div id="'.esc_attr($id).'" class="singlepage-shortcode singlepage-blog  '.esc_attr($class).'"><div>';
    $paged =(get_query_var('paged'))? get_query_var('paged'): 1;
    $wp_query = new WP_Query();
	$wp_query -> query('showposts='.$num.'&category_name='.$category.'&paged='.$paged."&post_status=publish&ignore_sticky_posts=1"); 
	$i = 1 ;
	if ($wp_query -> have_posts()) :
    while ( $wp_query -> have_posts() ) : $wp_query -> the_post();
	ob_start();
	get_template_part("content","article");
	$html .= ob_get_clean();
	endwhile;
	endif;
	 $html .= '</div>';
	 if( $page_nav == 'yes')
	 $html .= '<div class="list-pagition text-center">'.singlepage_native_pagenavi("",$wp_query).'</div>';
	 $html .= '</div>';
		wp_reset_postdata();
	 return $html ;	

	}


}

new Hoo_Blog();