<?php
class Hoo_Portfolio {

	private $column;
	private $animation_duration;
	private $animation_type;
	
	private $recent_works_counter = 1;
	
	public static $args;


    /**
     * Initiate the shortcode
     */
    public function __construct() {

		add_shortcode( 'portfolio', array( $this, 'render' ) );

    }

    /**
     * Render the parent shortcode
     * @param  array $args     Shortcode paramters
     * @param  string $content Content between shortcode
     * @return string          HTML output
     */
    function render( $args, $content = '') {
    	global $smof_data;

		$defaults = HooCore_Plugin::set_shortcode_defaults(
			array(
				'class' 				=> '',
				'id' 					=> '',
				'cat_slug' 				=> '',
				'columns' 				=> 3,
				'show_title'            => 'yes',
				'show_excerpt'          => 'yes',
				'exclude_cats' 			=> '',
				'excerpt_length' 		=> '',
				'excerpt_words' 		=> '15',  // depracted
				'number_posts' 			=> 8,
				'animation_duration' => '0.5',
				'animation_type' 		=> '',
				
			), $args
		);

	
		
		extract( $defaults );

		self::$args = $defaults;
		
		$this->animation_duration = $animation_duration;
		$this->animation_type = $animation_type;
		
		if( $excerpt_length || 
			$excerpt_length === '0' 
		) {
			$excerpt_words = $excerpt_length;
		}
				
		$args = array(
			'post_type' 			=> 'singlepage_portfolio',
			'paged' 				=> 1,
			'posts_per_page' 		=> $number_posts,
			'has_password' => false
		);

		if( self::$args['exclude_cats'] ) {
			$cats_to_exclude = explode( ',' , self::$args['exclude_cats'] );
		} else {
			$cats_to_exclude = '';
		}

		if( self::$args['cat_slug'] ) { 
			$cat_slugs = explode(',', self::$args['cat_slug']);
		} else {
			$cat_slugs = '';
		}

		if( isset ( $cats_to_exclude ) && $cats_to_exclude ) {
		
			$args['tax_query'] = array(
				array(
					'taxonomy' 	=> 'portfolio_category',
					'field' 	=> 'slug',
					'terms' 	=> $cats_to_exclude,
					'operator' 	=> 'NOT IN'
				)
			);

			if( $cat_slugs ) {
				$args['tax_query']['relation'] = 'AND';
				$args['tax_query'][] = array(
					'taxonomy' 	=> 'portfolio_category',
					'field' 	=> 'slug',
					'terms' 	=> $cat_slugs,
					'operator' 	=> 'IN'
				);
			}		
		
		} else {

			if( $cat_slugs ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' 	=> 'portfolio_category',
						'field' 	=> 'slug',
						'terms' 	=> $cat_slugs
					)
				);
			}
		
		}		
		
		wp_reset_query();
       
      if( $this->animation_type != "" )
		$animation_type = "wow ".$this->animation_type;
		
		$animation_duration = "";
		if( $this->animation_duration != "" )
		$animation_duration = "data-animationduration='".$this->animation_duration."'";
		
		$recent_works = new WP_Query( $args );
		$works  = '';
		$html   = '<div class="portfolio-list"><div class="portfolio-list-wrap">';
		$dataID = 1;
		switch($columns){
			case 1:
			$column = 12;
			break;
			case 2:
			$column = 6;
			break;
			case 3:
			$column = 4;
			break;
			case 4:
			$column = 3;
			break;
			default:
			$column = 3;
			break;
			}
		while( $recent_works->have_posts() ) { 
			$recent_works->the_post();
			$stripped_content = strip_shortcodes( tf_content( $excerpt_words,  $smof_data['strip_html_excerpt']  ) );

            $works .= '<article  data-id="id-'.$dataID.'"  class="entry-box text-left portfolio-item col-md-'.$column.' '.$animation_type.'" '.$animation_duration.'><span>';
 
						    
							if ( has_post_thumbnail()) {
								
						$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), "portfolio" );
						$src = $thumbnail[0];
						$alt = get_post_field( 'post_excerpt', get_post_thumbnail_id( get_the_ID() ) );
						
						$works .= '<img src="'.$src.'" alt="'.$alt.'" />';
								
								
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
							$featured_image = $image[0];
							
							
                            
                    $works .= '<div class="pd">
                                <a href="'.$featured_image.'" class="p-view" data-rel="prettyPhoto"></a>
                                <a href="'.get_permalink().'" class="p-link"></a>
                            </div>';
							}
                        $works .= '</span>';
						
					  if($show_title == "yes")
                      $works .= '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
					   if($show_excerpt == "yes"){
                      $works .= '<p>'.$stripped_content.'</p>';
                      $works .= '<a href="'. get_permalink().'" class="read-more">'. __("Read More","singlepage").' ...</a>';
					   }

					  $works .= '</article>';
					  
					 if($dataID % $columns == 0){
					 $html .= '<div class="row">'.$works.'</div>';
					 $works = '';
					 }
         
		
        $dataID++;
		$this->recent_works_counter++;

    }
	if( $works != '')
	 $html .= '<div class="row">'.$works.'</div>';
	$html   .= '</div></div>';
	 return $html;
    wp_reset_query();
    
}
}

new Hoo_Portfolio();