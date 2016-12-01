<?php
 add_action('init', 'singlepage_slider_register');
 function singlepage_slider_register() {
 
	$labels = array(
		'name' => __('Singlepage Slider',"singlepage"),
		'singular_name' => 'Singlepage Slider',
		'add_new_item' => __('Add New Slider',"singlepage"),
		'edit_item' => __('Edit Slider', 'singlepage'),
		'new_item' => __('New Slider', 'singlepage'),
		'view_item' => '',
		'all_items' => 'All Sliders',
		'search_items' => __('Search Slider', 'singlepage'),
		'not_found' =>  __('Nothing found', 'singlepage'),
		'not_found_in_trash' => __('Nothing found in Trash', 'singlepage'),
	);
 
	$args = array(
		'labels' => $labels,
		'public' => false,
		'show_ui' => true,
		'menu_icon' => get_template_directory_uri().'/images/singlepage-slider.png',
		'can_export' => true,
		'exclude_from_search' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 103,
		'rewrite' => array('slug' => 'slider'),
		'supports' => array('title')
	  ); 
 	   
	register_post_type( 'singlepage_slider' , $args );
   }

	add_action("admin_init", "singlepage_slider_init");
	 
 function singlepage_slider_init(){
	  add_meta_box("singlepage_slider_slides", "Slides", "singlepage_slider_slides", "singlepage_slider", "normal", "high");
	}
	 
 function singlepage_slider_slides(){
	global $post;
	$custom = get_post_meta($post->ID);
	$sliders = array();
	if(isset($custom["singlepage_slider"][0]))
	$sliders = unserialize( base64_decode($custom["singlepage_slider"][0]) );
    $sliders = stripslashes_deep( $sliders );

 $post_meta_box = array(
    'id'          => 'singlepage_slides',
    'title'       => __( 'Singlepage Slides', 'singlepage' ),
    'desc'        => '',
    'pages'       => array( 'post' ),
    'context'     => 'normal',
    'priority'    => 'high',
	
    'fields'      => array(
 
  array(
        'id'          => 'singlepage_slide_item',
      //  'label'       => __( 'Slide Item', 'singlepage' ),
     
        'std'         => $sliders,
        'type'        => 'list-item',
        'section'     => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'settings'    => array( 
							   
		    array(
        'id'          => 'slide_type',
        'label'       => __( 'Slide Type', 'singlepage' ),
        'desc'        => '',
        'std'         => 'image',
        'type'        => 'radio',
        'section'     => 'option_types',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'image',
            'label'       => __( 'Image', 'singlepage' ),
            'src'         => ''
          ),
          array(
            'value'       => 'html5_video',
            'label'       => __( 'Html5 video background', 'singlepage' ),
            'src'         => ''
          ),
          array(
            'value'       => 'iframe',
            'label'       => __( 'Full screen iframe', 'singlepage' ),
            'src'         => ''
			
          )
        )
      ),
			
		array(
        'id'          => 'loop',
        'label'       => __( 'Video Loop', 'singlepage' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition' => 'slide_type:is(html5_video)',
        'operator'    => 'and'
      ),
		array(
        'id'          => 'volume',
        'label'       => __( 'Volume', 'singlepage' ),
        'desc'        => '',
        'std'         => '0.5',
        'type'        => 'numeric-slider',
        'section'     => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '0,1,0.1',
        'class'       => '',
        'condition' => 'slide_type:is(html5_video)',
        'operator'    => 'and'
      ),
	    
		 array(
        'id'          => 'poster',
        'label'       => __( 'Poster', 'singlepage' ),
		'desc'        => __('Displaying the image for browsers that don\'t support the HTML5 Video element.','singlepage'),
        'std'         => '',
        'type'        => 'upload',
        'section'     => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition' => 'slide_type:is(html5_video)',
        'operator'    => 'and'
      ),
		 
		array(
        'id'          => 'mp4',
        'label'       => __( 'mp4 video url', 'singlepage' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'option_types',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'html5_video',
        'condition' => 'slide_type:is(html5_video)',
        'operator'    => 'and'
      ),
		array(
        'id'          => 'webm',
        'label'       => __( 'webm video url', 'singlepage' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'option_types',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'html5_video',
       'condition' => 'slide_type:is(html5_video)',
        'operator'    => 'and'
      ),
		array(
        'id'          => 'ogg',
        'label'       => __( 'ogg video url', 'singlepage' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'option_types',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'html5_video',
        'condition' => 'slide_type:is(html5_video)',
        'operator'    => 'and'
      ),
		
		 array(
        'id'          => 'pattern',
        'label'       => __( 'Pattern', 'singlepage' ),
		'desc'        =>'',
        'std'         => '',
        'type'        => 'upload',
        'section'     => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition' => 'slide_type:is(iframe)',
        'operator'    => 'and'
      ),
		 
		array(
        'id'          => 'iframe',
        'label'       => __( 'embed video url', 'singlepage' ),
        'desc'        => '',
        'std'         => esc_url('http://www.youtube.com/embed/KVwSP51KVO8?wmode=opaque'),
        'type'        => 'text',
        'section'     => 'option_types',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition' => 'slide_type:is(iframe)',
        'operator'    => 'and'
      ),
			
        array(
        'id'          => 'image',
        'label'       => __( 'Slide Image', 'singlepage' ),
		'desc'        => __( 'Upload slide image.', 'singlepage' ),
        'std'         => '',
        'type'        => 'upload',
        'section'     => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition' => 'slide_type:is(image)',
        'operator'    => 'and'
      ),
		 array(
        'id'          => 'slide_content',
        'label'       => __( 'Slide Content', 'singlepage' ),
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'option_types',
        'rows'        => '15',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition' => 'slide_type:is(image),slide_type:is(html5_video)',
        'operator'    => 'or'
      ),
		 
		 array(
        'id'          => 'content_typography',
        'label'       => __( 'Content Typography', 'singlepage' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'typography',
        'section'     => '',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition' => 'slide_type:is(image),slide_type:is(html5_video)',
        'operator'    => 'or'
      ),
		 
		 
        )
      ),
    )
  );

$meta = new OT_Meta_Box($post_meta_box);
$meta->add_meta_boxes2($post, $post_meta_box);

}
	add_action('save_post', 'singlepage_save_slide');
	function singlepage_save_slide(){
	  global $post;
	  if(isset($post->ID) && isset($_POST['singlepage_slide_item'])){
		
			$singlepage_slider = base64_encode(serialize($_POST['singlepage_slide_item']));
			update_post_meta($post->ID, 'singlepage_slider' , $singlepage_slider);		
		
	  }
	}
	
	add_filter("singlepage_edit-singlepage_slider_columns", "singlepage_slider_edit_columns");
	function singlepage_slider_edit_columns($columns){
	  $columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __("Title","singlepage"),
		"slides" => __("Number of Slides","singlepage"),
		"date" => __("Date","singlepage"),
	  );
	 
	  return $columns;
	}

	add_action("singlepage_singlepage_slider_posts_custom_column",  "singlepage_slider_custom_columns");
	function singlepage_slider_custom_columns($column){
		global $post;
		switch ($column) {
			case "slides":
				$singlepage_custom_slider_args = array( 'post_type' => 'singlepage_slider', 'p' => $post->ID );
				$singlepage_custom_slider = new WP_Query( $singlepage_custom_slider_args );
				while ( $singlepage_custom_slider->have_posts() ) {
					$number =0;
					$singlepage_custom_slider->the_post();
					$custom = get_post_custom($post->ID);
					if( !empty($custom["singlepage_slider"][0])){
						$slider = unserialize( base64_decode($custom["singlepage_slider"][0]) );
						echo $number = count($slider);
					}
					else echo 0;
				}
			break;
		}
	}


//
/*function singlepage_slider_show(){
	global $post;
	if( isset($post->ID) ){
		echo '[singlepage_slider id="'.$post->ID.'"]';
		}
	}
function singlepage_slider_metabox() {
add_meta_box(
        'singlepage_slider_shortcode',      // Unique ID
        esc_html(__( 'Slider Shortcode', 'singlepage' )),    // Title
        'singlepage_slider_show',   // Callback function
        'singlepage_slider',         // Admin page (or post type)
        'side',         // Context
        'default'         // Priority
    );
}

add_action( 'add_meta_boxes', 'singlepage_slider_metabox' );*/