<?php
/**
 * Initialize the custom Meta Boxes. 
 */
add_action( 'admin_init', 'singlepage_meta_boxes' );

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types in demo-theme-options.php.
 *
 * @return    void
 * @since     2.0
 */
function singlepage_meta_boxes() {
  
  /**
   * Create a custom meta boxes array that we pass to 
   * the OptionTree Meta Box API Class.
   */
  $page_meta_box = array(
    'id'          => 'singlepage_meta_box',
    'title'       => __( 'Page Meta Box', 'singlepage' ),
    'desc'        => '',
    'pages'       => array( 'page' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
       array(
        'id'          => 'page_layout',
        'label'       => __( 'Page Layout', 'singlepage' ),
        'desc'        => '',
        'std'         => 'full-width',
        'type'        => 'radio-image',
        'section'     => 'option_types',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
	   
	    array(
        'id'          => 'show_title',
        'label'       => __( 'Display Title', 'singlepage' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'option_types',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
		
		 array(
        'id'          => 'show_breadcrumb',
        'label'       => __( 'Display Breadcrumb', 'singlepage' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'option_types',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
     
    )
  );
  
 /* $post_meta_box = array(
    'id'          => 'singlepage_meta_box',
    'title'       => __( 'Post Meta Box', 'singlepage' ),
    'desc'        => '',
    'pages'       => array( 'post' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
		
		 array(
        'id'          => 'page_style',
        'label'       => __( 'Page Style', 'singlepage' ),
        'desc'        => '',
        'std'         => '1',
        'type'        => 'select',
        'section'     => 'singlepage_meta_box',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
		 'choices'     => array( 
          array(
            'value'       => '1',
            'label'       => __( 'Style 1', 'singlepage' ),
            'src'         => ''
          ),
          array(
            'value'       => '2',
            'label'       => __( 'Style 2', 'singlepage' ),
            'src'         => ''
          )
        )
      ),
     
    )
  );*/
  
   $portfolio_meta_box = array(
    'id'          => 'portfolio_meta_box',
    'title'       => __( 'Portfolio Meta Box', 'singlepage' ),
    'desc'        => '',
    'pages'       => array( 'singlepage_portfolio' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
						   
	  array(
        'label'       => __( 'General Options', 'singlepage' ),
        'id'          => 'general_options',
        'type'        => 'tab',
		'section'     => ''
		
      ),

	   array(
        'id'          => 'show_related_portfolios',
        'label'       => __( 'Display Related Portfolios', 'singlepage' ),
        'std'         => 'on',
        'type'        => 'on-off',
		'section'     => 'general_options'
      ),
      array(
        'label'       => __( 'Gallery', 'singlepage' ),
        'id'          => 'gallery',
        'type'        => 'tab'
      ),
	  
      array(
        'id'          => 'portfolio_gallery',
        'label'       => __( 'Gallery', 'singlepage' ),
        'std'         => '',
        'type'        => 'gallery',
        'section'     => 'gallery',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
	  array(
        'label'       => __( 'Attributes', 'singlepage' ),
        'id'          => 'attributes',
        'type'        => 'tab'
      ),
	  
	
	   array(
        'id' => 'project_date',
        'label' => __( 'Project Date', 'singlepage' ),
        'desc' => '',
        'std' => '',
        'type' => 'date-picker',
        'section' => '',
        'rows' => '',
        'post_type' => '',
        'taxonomy' => '',
        'min_max_step'=> '',
        'class' => '',
        'condition' => '',
        'operator' => 'and'
      ),
	     array(
        'id'          => 'project_site',
        'label'       => __( 'Project Site', 'singlepage' ),
        'std'         => '',
        'type'        => 'text',
		'section'     => ''
      ),
	   array(
        'id'          => 'site_link',
        'label'       => __( 'Site Link', 'singlepage' ),
        'std'         => '',
        'type'        => 'text',
		'section'     => ''
      ),
	   array(
        'id'          => 'client',
        'label'       => __( 'Client', 'singlepage' ),
        'std'         => '',
        'type'        => 'text',
		'section'     => ''
      )
	   
    )
  );
     $postid = get_the_ID();
     $postid = isset($_GET['post'])?$_GET['post']:'';
	
   $singlepage_slider_meta_box = array(
    'id'          => 'singlepage_slider_meta_box',
    'title'       => __( 'Slider Metabox', 'singlepage' ),
    'desc'        => '',
    'pages'       => array( 'singlepage_slider' ),
    'context'     => 'side',
    'priority'    => 'high',
    'fields'      => array(
		
		 array(
        'id'          => 'page_style',
        'label'       => __( 'Slider Shortcode', 'singlepage' ),
        'desc'        => '[singlepage_slider id="'.$postid.'"]',
        'std'         => '',
        'type'        => 'textblock_titled',
        'section'     => 'singlepage_meta_box',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
		 'choices'     => ''
      ),
     
    )
  );
   
    $singlepage_slider_meta_box2 = array(
    'id'          => 'singlepage_slider_meta_box2',
    'title'       => __( 'Slider Metabox', 'singlepage' ),
    'desc'        => '',
    'pages'       => array( 'singlepage_slider' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
		

		 array(
        'id'          => 'autoplay',
        'label'       => __( 'autoPlay', 'singlepage' ),
        'desc'        => '',
        'std'         => '0',
        'type'        => 'select',
        'section'     => 'singlepage_meta_box',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
		 'choices'     => array( 
          array(
            'value'       => '0',
            'label'       => __( 'No', 'singlepage' ),
            'src'         => ''
          ),
          array(
            'value'       => '1',
            'label'       => __( 'Yes', 'singlepage' ),
            'src'         => ''
          )
        )
      ),
		  array(
        'id'          => 'fullwidth',
        'label'       => __( 'Full Width( For shortcode )', 'singlepage' ),
        'desc'        => '',
        'std'         => '0',
        'type'        => 'select',
        'section'     => 'singlepage_meta_box',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
		 'choices'     => array( 
          array(
            'value'       => '0',
            'label'       => __( 'No', 'singlepage' ),
            'src'         => ''
          ),
          array(
            'value'       => '1',
            'label'       => __( 'Yes', 'singlepage' ),
            'src'         => ''
          )
        )
      ), array(
        'id'          => 'timeout',
        'label'       => __( 'TimeOut', 'singlepage' ),
        'std'         => '4000',
        'type'        => 'text',
		'section'     => 'singlepage_meta_box'
      )
		  
     
    )
  );
  /**
   * Register our meta boxes using the 
   * ot_register_meta_box() function.
   */
  if ( function_exists( 'ot_register_meta_box' ) )
    ot_register_meta_box( $page_meta_box );
   // ot_register_meta_box( $post_meta_box );
	ot_register_meta_box( $portfolio_meta_box );
	ot_register_meta_box( $singlepage_slider_meta_box );
	ot_register_meta_box( $singlepage_slider_meta_box2 );

}