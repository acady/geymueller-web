<?php
/*-----------------------------------------------------------------------------------*/
/*	Default Options
/*-----------------------------------------------------------------------------------*/

// Number of posts array
function hoo_shortcodes_range ( $range, $all = true, $default = false, $range_start = 1 ) {
	if( $all ) {
		$number_of_posts['-1'] = 'All';
	}

	if( $default ) {
		$number_of_posts[''] = 'Default';
	}

	foreach( range( $range_start, $range ) as $number ) {
		$number_of_posts[$number] = $number;
	}

	return $number_of_posts;
}

// Taxonomies
function hoo_shortcodes_categories ( $taxonomy, $empty_choice = false ) {
	if( $empty_choice == true ) {
		$post_categories[''] = 'Default';
	}

	$get_categories = get_categories('hide_empty=0&taxonomy=' . $taxonomy);

	if( ! array_key_exists('errors', $get_categories) ) {
		if( $get_categories && is_array($get_categories) ) {
			foreach ( $get_categories as $cat ) {
				if(isset($cat->slug) && isset($cat->name))
				$post_categories[$cat->slug] = $cat->name;
			}
		}

		if( isset( $post_categories ) ) {
			return $post_categories;
		}
	}
}

$choices = array( 'yes' => 'Yes', 'no' => 'No' );
$reverse_choices = array( 'no' => 'No', 'yes' => 'Yes' );
$choices_with_default = array( '' => 'Default', 'yes' => 'Yes', 'no' => 'No' );
$reverse_choices_with_default = array( '' => 'Default', 'no' => 'No', 'yes' => 'Yes' );
$leftright = array( 'left' => 'Left', 'right' => 'Right' );
$dec_numbers = array( '0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1' => '1', '2' => '2', '2.5' => '2.5', '3' => '3' );
$animation_type = array('' => 'None',"bounce" => "bounce", "flash" => "flash", "pulse" => "pulse", "rubberBand" => "rubberBand", "shake" => "shake", "swing" => "swing", "tada" => "tada", "wobble" => "wobble", "bounceIn" => "bounceIn", "bounceInDown" => "bounceInDown", "bounceInLeft" => "bounceInLeft", "bounceInRight" => "bounceInRight", "bounceInUp" => "bounceInUp", "bounceOut" => "bounceOut", "bounceOutDown" => "bounceOutDown", "bounceOutLeft" => "bounceOutLeft", "bounceOutRight" => "bounceOutRight", "bounceOutUp" => "bounceOutUp", "fadeIn" => "fadeIn", "fadeInDown" => "fadeInDown", "fadeInDownBig" => "fadeInDownBig", "fadeInLeft" => "fadeInLeft", "fadeInLeftBig" => "fadeInLeftBig", "fadeInRight" => "fadeInRight", "fadeInRightBig" => "fadeInRightBig", "fadeInUp" => "fadeInUp", "fadeInUpBig" => "fadeInUpBig", "fadeOut" => "fadeOut", "fadeOutDown" => "fadeOutDown", "fadeOutDownBig" => "fadeOutDownBig", "fadeOutLeft" => "fadeOutLeft", "fadeOutLeftBig" => "fadeOutLeftBig", "fadeOutRight" => "fadeOutRight", "fadeOutRightBig" => "fadeOutRightBig", "fadeOutUp" => "fadeOutUp", "fadeOutUpBig" => "fadeOutUpBig", "flip" => "flip", "flipInX" => "flipInX", "flipInY" => "flipInY", "flipOutX" => "flipOutX", "flipOutY" => "flipOutY", "lightSpeedIn" => "lightSpeedIn", "lightSpeedOut" => "lightSpeedOut", "rotateIn" => "rotateIn", "rotateInDownLeft" => "rotateInDownLeft", "rotateInDownRight" => "rotateInDownRight", "rotateInUpLeft" => "rotateInUpLeft", "rotateInUpRight" => "rotateInUpRight", "rotateOut" => "rotateOut", "rotateOutDownLeft" => "rotateOutDownLeft", "rotateOutDownRight" => "rotateOutDownRight", "rotateOutUpLeft" => "rotateOutUpLeft", "rotateOutUpRight" => "rotateOutUpRight", "hinge" => "hinge", "rollIn" => "rollIn", "rollOut" => "rollOut", "zoomIn" => "zoomIn", "zoomInDown" => "zoomInDown", "zoomInLeft" => "zoomInLeft", "zoomInRight" => "zoomInRight", "zoomInUp" => "zoomInUp", "zoomOut" => "zoomOut", "zoomOutDown" => "zoomOutDown", "zoomOutLeft" => "zoomOutLeft", "zoomOutRight" => "zoomOutRight", "zoomOutUp" => "zoomOutUp", "slideInDown" => "slideInDown", "slideInLeft" => "slideInLeft", "slideInRight" => "slideInRight", "slideInUp" => "slideInUp", "slideOutDown" => "slideOutDown", "slideOutLeft" => "slideOutLeft", "slideOutRight" => "slideOutRight", "slideOutUp" => "slideOutUp");
$columns  = array(""=>"default","1"=>"1/12","2"=>"2/12","3"=>"3/12","4"=>"4/12","5"=>"5/12","6"=>"6/12","7"=>"7/12","8"=>"8/12","9"=>"9/12","10"=>"10/12","11"=>"11/12","12"=>"12/12");
// Fontawesome icons list
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path = SINGLEPAGE_THEME_DIR . 'css/font-awesome.css';

if( file_exists( $fontawesome_path ) ) {
	@$subject = file_get_contents( $fontawesome_path );
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$icons = array();

foreach($matches as $match){
	$icons[$match[1]] = $match[2];
}

$checklist_icons = array ( 'icon-check' => '\f00c', 'icon-star' => '\f006', 'icon-angle-right' => '\f105', 'icon-asterisk' => '\f069', 'icon-remove' => '\f00d', 'icon-plus' => '\f067' );

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Selection Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['shortcode-generator'] = array(
	'no_preview' => true,
	'params' => array(),
	'shortcode' => '',
	'popup_title' => ''
);


/*-----------------------------------------------------------------------------------*/
/*	Accordion Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['accordion'] = array(
	'no_preview' => true,
	'params' => array(

		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),	
		),
	'shortcode' => '[accordion  class="{{class}}" id="{{id}}"]{{child_shortcode}}[/accordion]',
	'popup_title' => __( 'Accordion Shortcode', 'singlepage' ),
		// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
						  
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Title', 'singlepage' ),
			'desc' => ''
		),	
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Text', 'singlepage' ),
			'desc' => __( 'Insert text here. ', 'singlepage' ),
		),	
		'status' => array(
			'std' => 'close',
			'type' => 'select',
			'label' => __( 'Status', 'singlepage' ),
			'desc' => '',
			'options' => array("close"=>"close","open"=>"open")
		)
		
           )
		,
	'shortcode' => '[accordion_item title="{{title}}" status="{{status}}"]{{content}}[/accordion_item]',
		'clone_button' => __( 'Add New Accordion Item', 'singlepage')
		
		)

);

/*-----------------------------------------------------------------------------------*/
/*	Alert Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(

		
	'type' => array(
			'type' => 'select',
			'label' => __( 'Alert Box Type', 'singlepage' ),
			'desc' => '',
			'options' => array('info'=>'info','success'=>'success','warning'=>'warning','error'=>'error')
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Text', 'singlepage' ),
			'desc' => __( 'Insert text here. ', 'singlepage' ),
		)
		
		
	),
	'shortcode' => '[alert type="{{type}}" class="{{class}}" id="{{id}}"]{{content}}[/alert]',
	'popup_title' => __( 'Alert Shortcode', 'singlepage' )
);

/*-----------------------------------------------------------------------------------*/
/*	Blog Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['blog'] = array(
	'no_preview' => true,
	'params' => array(

	'num' => array(
			'type' => 'text',
			'label' => __( 'List Num', 'singlepage' ),
			'desc' => '',
			"std"=>"10"
			
		),
	'category' => array(
			'type' => 'select',
			'label' => __( 'Category', 'singlepage' ),
			'desc' => '',
			'options' => hoo_shortcodes_categories( 'category',true )
		),
	'page_nav' => array(
			'type' => 'select',
			'label' => __( 'Show Page Navigation', 'singlepage' ),
			'desc' => '',
			'options' => $choices
		),
	
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		)
		
		
	),
	'shortcode' => '[blog num="{{num}}"  category="{{category}}" page_nav="{{page_nav}}"  class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Blog Shortcode', 'singlepage' )
);

/*-----------------------------------------------------------------------------------*/
/*	Boxed Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['boxed'] = array(
	'no_preview' => true,
	'params' => array(
		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Text', 'singlepage' ),
			'desc' => __( 'Insert text or html code here. ', 'singlepage' ),
		)
		
		
	),
	'shortcode' => '[boxed class="{{class}}" id="{{id}}"]{{content}}[/boxed]',
	'popup_title' => __( 'Boxed Shortcode', 'singlepage' )
);

/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(

		'content' => array(
			'type' => 'text',
			'label' => __( 'Button Text', 'singlepage' ),
			'desc' => '',
			'std' => 'Button'
		),
		
		'link' => array(
			'std' => 'http://',
			'type' => 'text',
			'label' => __( 'Link', 'singlepage' ),
			'desc' => __( 'Button link', 'singlepage' )
		),
		'target' => array(
			'type' => 'select',
			'label' => __( 'Target', 'singlepage' ),
			'desc' => '',
			'options' => array('_blank'=>'_blank','_self'=>'_self')
			
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Button Color', 'singlepage' ),
			'desc' => '',
			'std' =>'#4ca702'
		),
		
	'size' => array(
			'type' => 'select',
			'label' => __( 'Button Size', 'singlepage' ),
			'desc' => '',
			'options' => array(''=>'normal','medium'=>'medium','large'=>'large')
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),		
		
		
	),
	'shortcode' => '[button color="{{color}}"  link="{{link}}" size="{{size}}"   target="{{target}}" class="{{class}}" id="{{id}}"]{{content}}[/button]',
	'popup_title' => __( 'Button Shortcode', 'singlepage' )
);


/*-----------------------------------------------------------------------------------*/
/*	Column Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['column'] = array(
	'no_preview' => true,
	'params' => array(
		
	   'col_xs' => array(
			'type' => 'select',
			'label' => __( 'Extra small grid( &lt; 768px)', 'singlepage' ),
			'desc' => __("Select column width. This width will be calculated depend page width.",'singlepage'),
			'options' => $columns 
		),
	    'col_sm' => array(
			'type' => 'select',
			'label' => __( 'Small grid( &ge; 768px)', 'singlepage' ),
			'desc' => '',
			'std'  => 6,
			'options' =>  $columns 
		),
		
		 'col_md' => array(
			'type' => 'select',
			'label' => __( 'Medium grid( &ge;  992px)', 'singlepage' ),
			'desc' => '',
			'std'  => 3,
			'options' =>  $columns 
		),
		 'col_lg' => array(
			'type' => 'select',
			'label' => __( 'Large grid( &ge;  1200px)', 'singlepage' ),
			'desc' => '',
			'std'  => '',
			'options' =>  $columns 
		),
		 
		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Text', 'singlepage' ),
			'desc' => __( 'Insert text or html code here. ', 'singlepage' ),
		)
		
		
	),
	'shortcode' => '[column col_xs="{{col_xs}}" col_sm="{{col_sm}}" col_md="{{col_md}}" col_lg="{{col_lg}}" class="{{class}}" id="{{id}}"]{{content}}[/column]',
	'popup_title' => __( 'Column Shortcode', 'singlepage' )
);

/*-----------------------------------------------------------------------------------*/
/*	Contact Form Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['contact_form'] = array(
	'no_preview' => true,
	'params' => array(
         'receiver_email' => array(
			'std' => get_option( 'admin_email' ),
			'type' => 'text',
			'label' => __( 'Receiver Email', 'singlepage' ),
			'desc' => ''
		),
		'color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Text Color', 'singlepage' ),
			'desc' => ''
		),	
		'border_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Border Color', 'singlepage' ),
			'desc' =>  __( 'Form field border color.', 'singlepage' ),
		),
		 'button_text' => array(
			'std' => 'Send It',
			'type' => 'text',
			'label' => __( 'Submit Button Text', 'singlepage' ),
			'desc' => ''
		),
		 
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),
		
		),
	'shortcode' => '[contact_form  class="{{class}}" id="{{id}}" receiver_email="{{receiver_email}}" color="{{color}}" border_color="{{border_color}}" button_text="{{button_text}}"]{{child_shortcode}}[/contact_form]',
	'popup_title' => __( 'Contact Form Shortcode', 'singlepage' ),
		// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __( 'Field Type', 'singlepage' ),
			'desc' => '',
			'options' => array('text'=>'Text Field','email'=>'Email','textarea'=>'Textarea')
				),		  
		'placeholder' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Placeholder', 'singlepage' ),
			'desc' => ''
		),
		'width' => array(
			'type' => 'select',
			'label' => __( 'Width', 'singlepage' ),
			'desc' => __( 'Form field width.', 'singlepage' ),
			'options' => array('full'=>'Full','half'=>'Half')
				),
		'required' => array(
			'type' => 'select',
			'label' => __( 'Required', 'singlepage' ),
			'desc' => __( 'This field will be required.', 'singlepage' ),
			'options' => $choices
		),
		
           )
		,
	'shortcode' => '[contact_form_field type="{{type}}" placeholder="{{placeholder}}" width="{{width}}" required="{{required}}"][/contact_form_field]',
		'clone_button' => __( 'Add New Field Item', 'singlepage')
		
		)

);



/*-----------------------------------------------------------------------------------*/
/*	Counter Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['counter'] = array(
	'no_preview' => true,
	'params' => array(

		
	'num' => array(
			'type' => 'text',
			'label' => __( 'Number', 'singlepage' ),
			'desc' => '',
			'std' => 80
	
		),
		
	'name' => array(
			'type' => 'text',
			'label' => __( 'Name', 'singlepage' ),
			'desc' => '',
			'std' => ''
	
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		)
		
		
	),
	'shortcode' => '[counter num="{{num}}" name="{{name}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Counter Shortcode', 'singlepage' )
);

/*-----------------------------------------------------------------------------------*/
/*	Dropcap Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['dropcap'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'A',
			'type' => 'textarea',
			'label' => __( 'Dropcap Letter', 'singlepage' ),
			'desc' => __( 'Add the letter to be used as dropcap', 'singlepage' ),
		),
		'color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Color', 'singlepage' ),
			'desc' => __( 'Controls the color of the dropcap letter. Leave blank for theme option selection.', 'singlepage')
		),		
		'boxed' => array(
			'type' => 'select',
			'label' => __( 'Boxed Dropcap', 'singlepage' ),
			'desc' => __( 'Choose to get a boxed dropcap.', 'singlepage' ),
			'options' => $reverse_choices
		),
		'boxedradius' => array(
			'std' => '8px',
			'type' => 'text',
			'label' => __( 'Box Radius', 'singlepage' ),
			'desc' => 'Choose the radius of the boxed dropcap. In pixels (px), ex: 1px, or "round".'
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage')
		),
	),
	'shortcode' => '[dropcap color="{{color}}" boxed="{{boxed}}" boxed_radius="{{boxedradius}}" class="{{class}}" id="{{id}}"]{{content}}[/dropcap]',
	'popup_title' => __( 'Dropcap Shortcode', 'singlepage' )
);

/*-----------------------------------------------------------------------------------*/
/*	Fact Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['fact'] = array(
	'no_preview' => true,
	'params' => array(

		
	'num' => array(
			'type' => 'text',
			'label' => __( 'Number', 'singlepage' ),
			'desc' => '',
			'std' => 80
	
		),
		
	'name' => array(
			'type' => 'text',
			'label' => __( 'Name', 'singlepage' ),
			'desc' => '',
			'std' => ''
	
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		)
		
		
	),
	'shortcode' => '[fact num="{{num}}" name="{{name}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Fact Shortcode', 'singlepage' )
);

/*-----------------------------------------------------------------------------------*/
/*	Fullwidth Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['fullwidth'] = array(
	'no_preview' => true,
	'params' => array(
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Background Color', 'singlepage' ),
			'desc' => __( 'Controls the background color.  Leave blank for theme option selection.', 'singlepage')
		),
		'backgroundimage' => array(
			'type' => 'uploader',
			'label' => __( 'Backgrond Image', 'singlepage' ),
			'desc' => 'Upload an image to display in the background'
		),
		'backgroundrepeat' => array(
			'type' => 'select',
			'label' => __( 'Background Repeat', 'singlepage' ),
			'desc' => 'Choose how the background image repeats.',
			'options' => array(
				'no-repeat' => 'No Repeat',
				'repeat' => 'Repeat Vertically and Horizontally',
				'repeat-x' => 'Repeat Horizontally',
				'repeat-y' => 'Repeat Vertically'
			)
		),
		'backgroundposition' => array(
			'type' => 'select',
			'label' => __( 'Background Position', 'singlepage' ),
			'desc' => 'Choose the postion of the background image',
			'options' => array(
				'left top' => 'Left Top',
				'left center' => 'Left Center',
				'left bottom' => 'Left Bottom',
				'right top' => 'Right Top',
				'right center' => 'Right Center',
				'right bottom' => 'Right Bottom',
				'center top' => 'Center Top',
				'center center' => 'Center Center',
				'center bottom' => 'Center Bottom'
			)
		),
		'backgroundattachment' => array(
			'type' => 'select',
			'label' => __( 'Background Scroll', 'singlepage' ),
			'desc' => 'Choose how the background image scrolls',
			'options' => array(
				'scroll' => 'Scroll: background scrolls along with the element',
				'fixed' => 'Fixed: background is fixed giving a parallax effect',
				'local' => 'Local: background scrolls along with the element\'s contents'
			)
		),
		'bordersize' => array(
			'std' => '0px',
			'type' => 'text',
			'label' => __( 'Border Size', 'singlepage' ),
			'desc' => __( 'In pixels (px), ex: 1px. Leave blank for theme option selection.', 'singlepage' ),
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Border Color', 'singlepage' ),
			'desc' => __( 'Controls the border color.  Leave blank for theme option selection.', 'singlepage')
		),
		'borderstyle' => array(
			'type' => 'select',
			'label' => __( 'Border Style', 'singlepage' ),
			'desc' => __( 'Controls the border style.', 'singlepage' ),
			'options' => array(
				'solid' => 'Solid',
				'dashed' => 'Dashed',
				'dotted' => 'Dotted'
			)			
		),		
		'paddingtop' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Top', 'singlepage' ),
			'desc' => __( 'In pixels', 'singlepage' ),
			'options' => hoo_shortcodes_range( 100, false )
		),
		'paddingbottom' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Bottom', 'singlepage' ),
			'desc' => __( 'In pixels', 'singlepage' ),
			'options' => hoo_shortcodes_range( 100, false )
		),
		'menuanchor' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Name Of Menu Anchor', 'singlepage' ),
			'desc' => 'This name will be the id you will have to use in your one page menu.',
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'singlepage' ),
			'desc' => __( 'Add content', 'singlepage' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage')
		),			
	),
	'shortcode' => '[fullwidth menu_anchor="{{menuanchor}}" backgroundcolor="{{backgroundcolor}}" backgroundimage="{{backgroundimage}}" backgroundrepeat="{{backgroundrepeat}}" backgroundposition="{{backgroundposition}}" backgroundattachment="{{backgroundattachment}}" bordersize="{{bordersize}}" bordercolor="{{bordercolor}}" borderstyle="{{borderstyle}}" paddingtop="{{paddingtop}}px" paddingbottom="{{paddingbottom}}px" class="{{class}}" id="{{id}}"]{{content}}[/fullwidth]',
	'popup_title' => __( 'Fullwidth Shortcode', 'singlepage' )
);
/*-----------------------------------------------------------------------------------*/
/*	Google Map Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['googlemap'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __( 'Map Type', 'singlepage' ),
			'desc' => __( 'Select the type of google map to display.', 'singlepage' ),
			'options' => array(
				'roadmap' => 'Roadmap',
				'satellite' => 'Satellite',
				'hybrid' => 'Hybrid',
				'terrain' => 'Terrain'
			)
		),
		'width' => array(
			'std' => '100%',
			'type' => 'text',
			'label' => __( 'Map Width', 'singlepage' ),
			'desc' => __( 'Map width in percentage or pixels. ex: 100%, or 940px', 'singlepage')
		),
		'height' => array(
			'std' => '300px',
			'type' => 'text',
			'label' => __( 'Map Height', 'singlepage' ),
			'desc' => __( 'Map height in percentage or pixels. ex: 100%, or 300px', 'singlepage')
		),
		'zoom' => array(
			'std' => 14,
			'type' => 'select',
			'label' => __( 'Zoom Level', 'singlepage' ),
			'desc' => __( 'Higher number will be more zoomed in.', 'singlepage' ),
			'options' => hoo_shortcodes_range( 25, false )
		),
		'scrollwheel' => array(
			'type' => 'select',
			'label' => __( 'Scrollwheel on Map', 'singlepage' ),
			'desc' => __( 'Enable zooming using a mouse\'s scroll wheel.', 'singlepage' ),
			'options' => $choices
		),
		'scale' => array(
			'type' => 'select',
			'label' => __( 'Show Scale Control on Map', 'singlepage' ),
			'desc' => __( 'Display the map scale.', 'singlepage' ),
			'options' => $choices
		),
		'zoom_pancontrol' => array(
			'type' => 'select',
			'label' => __( 'Show Pan Control on Map', 'singlepage' ),
			'desc' => __( 'Displays pan control button.', 'singlepage' ),
			'options' => $choices
		),
		'popup' => array(
			'type' => 'select',
			'label' => __( 'Show tooltip by default?', 'singlepage' ),
			'desc' => __( 'Display or hide the tooltip when the map first loads.', 'singlepage' ),
			'options' => $choices
		),
		'mapstyle' => array(
			'type' => 'select',
			'label' => __( 'Select the Map Styling', 'singlepage' ),
			'desc' => __( 'Choose default styling for classic google map styles. Choose theme styling for our custom style. Choose custom styling to make your own with the advanced options below.', 'singlepage' ),
			'options' => array(
				'default' => 'Default Styling',
				'theme' => 'Theme Styling',
				'custom' => 'Custom Styling',
			)
		),	
		'overlaycolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Map Overlay Color', 'singlepage' ),
			'desc' => __( 'Custom styling setting only. Pick an overlaying color for the map. Works best with "roadmap" type.', 'singlepage')
		),
		'infobox' => array(
			'type' => 'select',
			'label' => __( 'Infobox Styling', 'singlepage' ),
			'desc' => __( 'Custom styling setting only. Choose between default or custom info box.', 'singlepage' ),
			'options' => array(
				'default' => 'Default Infobox',
				'custom' => 'Custom Infobox',
			)
		),
		'infoboxcontent' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Infobox Content', 'singlepage' ),
			'desc' => __( 'Custom styling setting only. Type in custom info box content to replace address string. For multiple addresses, separate info box contents by using the | symbol. ex: InfoBox 1|InfoBox 2|InfoBox 3', 'singlepage' ),
		),		
		'infoboxtextcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Info Box Text Color', 'singlepage' ),
			'desc' => __( 'Custom styling setting only. Pick a color for the info box text.', 'singlepage')
		),
		'infoboxbackgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Info Box Background Color', 'singlepage' ),
			'desc' => __( 'Custom styling setting only. Pick a color for the info box background.', 'singlepage')
		),
		'icon' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Custom Marker Icon', 'singlepage' ),
			'desc' => __( 'Custom styling setting only. Use full image urls for custom marker icons or input "theme" for our custom marker. For multiple addresses, separate icons by using the | symbol or use one for all. ex: Icon 1|Icon 2|Icon 3', 'singlepage' ),
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Address', 'singlepage' ),
			'desc' => __( 'Add address to the location which will show up on map. For multiple addresses, separate addresses by using the | symbol. <br />ex: Address 1|Address 2|Address 3', 'singlepage' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' ),
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' ),
		)
	),
	'shortcode' => '[map address="{{content}}" type="{{type}}" map_style="{{mapstyle}}" overlay_color="{{overlaycolor}}" infobox="{{infobox}}" infobox_background_color="{{infoboxbackgroundcolor}}" infobox_text_color="{{infoboxtextcolor}}" infobox_content="{{infoboxcontent}}" icon="{{icon}}" width="{{width}}" height="{{height}}" zoom="{{zoom}}" scrollwheel="{{scrollwheel}}" scale="{{scale}}" zoom_pancontrol="{{zoom_pancontrol}}" popup="{{popup}}" class="{{class}}" id="{{id}}"][/map]',
	'popup_title' => __( 'Google Map Shortcode', 'singlepage' )
);
/*-----------------------------------------------------------------------------------*/
/*	Image Carousel Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['imagecarousel'] = array(
	'params' => array(
		
		'items' => array(
			'std' => '4',
			'type' => 'select',
			'label' => __( 'Items', 'singlepage' ),
			'desc' => __( 'This variable allows you to set the maximum amount of items displayed at a time with the widest browser width', 'singlepage' ),
			'options' => array_combine(range(1,10), range(1,10)) 
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),			
	),
	'shortcode' => '[imagecarousel items="{{items}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/imagecarousel]', // as there is no wrapper shortcode
	'popup_title' => __( 'Image Carousel Shortcode', 'singlepage' ),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'url' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Image Website Link', 'singlepage' ),
				'desc' => __( 'Add the url to image\'s website. If lightbox option is enabled, you have to add the full image link to show it in the lightbox.', 'singlepage' )
			),
			'target' => array(
				'type' => 'select',
				'label' => __( 'Link Target', 'singlepage' ),
				'desc' => __( '_self = open in same window <br />_blank = open in new window', 'singlepage' ),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'image' => array(
				'type' => 'uploader',
				'label' => __( 'Image', 'singlepage' ),
				'desc' => __( 'Upload an image to display.', 'singlepage' ),
			),
			'alt' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Image Alt Text', 'singlepage' ),
				'desc' => __( 'The alt attribute provides alternative information if an image cannot be viewed.', 'singlepage' ),
			)
		),
		'shortcode' => '[image link="{{url}}" linktarget="{{target}}" image="{{image}}" alt="{{alt}}"]',
		'clone_button' => __( 'Add New Image', 'singlepage' )
	)
);

/*-----------------------------------------------------------------------------------*/
/*	List Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['list'] = array(
	'no_preview' => true,
	'params' => array(
         'icon_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Color', 'singlepage' ),
			'desc' => ''
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Select Icon', 'singlepage' ),
			'desc' => __( 'Click an icon to select, click again to deselect', 'singlepage' ),
			'options' => $icons
		),
		'border' => array(
			'type' => 'select',
			'label' => __( 'Border Bottom', 'singlepage' ),
			'desc' => '',
			'options' => array("0"=>"no","1"=>"yes")
		),
		'font_size' => array(
			'type' => 'select',
			'label' => __( 'Font Size', 'singlepage' ),
			'desc' => '',
			'std' => '16',
			'options' =>  array_combine(range(1,24), range(1,24)) 
		),
		'animation_type' => array(
			'type' => 'select',
			'label' => __( 'List Item Animation Type', 'singlepage' ),
			'desc' => '',
			'options' => $animation_type
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),	
		),
	'shortcode' => '[list icon="{{icon}}"  icon_color="{{icon_color}}" border="{{border}}" font_size="{{font_size}}" animation_type="{{animation_type}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/list]',
	'popup_title' => __( 'Accordion Shortcode', 'singlepage' ),
		// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Text', 'singlepage' ),
			'desc' => __( 'Insert text here. ', 'singlepage' ),
		)
           )
		,
	'shortcode' => '[list_item]{{content}}[/list_item]',
		'clone_button' => __( 'Add New List Item', 'singlepage')
		
		)

);

/*-----------------------------------------------------------------------------------*/
/*	Portfolio Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['portfolio'] = array(
	'no_preview' => true,
	'params' => array(
		
		'columns' => array(
			'type' => 'select',
			'std' => 4,
			'label' => __( 'Columns', 'singlepage' ),
			'desc' => __( 'Select the number of columns to display', 'singlepage' ),
			'options' => hoo_shortcodes_range( 4, false )
		),
		'cat_slug' => array(
			'type' => 'multiple_select',
			'label' => __( 'Categories', 'singlepage' ),
			'desc' => __( 'Select a category or leave blank for all', 'singlepage' ),
			'options' => hoo_shortcodes_categories( 'portfolio_category' )
		),
		'exclude_cats' => array(
			'type' => 'multiple_select',
			'label' => __( 'Exclude Categories', 'singlepage' ),
			'desc' => __( 'Select a category to exclude', 'singlepage' ),
			'options' => hoo_shortcodes_categories( 'portfolio_category' )
		),		
		'number_posts' => array(
			'std' => 4,
			'type' => 'select',
			'label' => __( 'Number of Posts', 'singlepage' ),
			'desc' => 'Select the number of posts to display',
			'options' => hoo_shortcodes_range( 12, false )
		),
		'excerpt_length' => array(
			'std' => 35,
			'type' => 'select',
			'label' => __( 'Excerpt Length', 'singlepage' ),
			'desc' => 'Insert the number of words/characters you want to show in the excerpt',
			'options' => hoo_shortcodes_range( 60, false )
		),
		'show_title' => array(
			'type' => 'select',
			'label' => __( 'Show Title', 'singlepage' ),
			'desc' => '',
			'options' => array("no"=>"no","yes"=>"yes")
		),
		'show_excerpt' => array(
			'type' => 'select',
			'label' => __( 'Show Excerpt', 'singlepage' ),
			'desc' => '',
			'options' => array("no"=>"no","yes"=>"yes")
		),
		
		'animation_type' => array(
			'type' => 'select',
			'label' => __( 'Content Animation Type', 'singlepage' ),
			'desc' => '',
			'options' => $animation_type
		),
		'animation_duration' => array(
			'type' => 'select',
			'std' => '',
			'label' => __( 'Speed of Animation', 'singlepage' ),
			'desc' => __( 'Type in speed of animation in seconds.', 'singlepage' ),
			'options' => $dec_numbers,
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),			
	),
	'shortcode' => '[portfolio columns="{{columns}}" cat_slug="{{cat_slug}}" exclude_cats="{{exclude_cats}}" number_posts="{{number_posts}}" excerpt_length="{{excerpt_length}}" show_title="{{show_title}}" show_excerpt="{{show_excerpt}}" animation_type="{{animation_type}}"  animation_duration="{{animation_duration}}" class="{{class}}" id="{{id}}"][/portfolio]',
	'popup_title' => __( 'Recent Works Shortcode', 'singlepage' )
);

/*-----------------------------------------------------------------------------------*/
/*	Post Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['hoo_post'] = array(
	'no_preview' => true,
	'params' => array(
		
		'field' => array(
			'type' => 'select',
			'std' => 'post_content',
			'label' => __( 'Field', 'singlepage' ),
			'desc' => __( 'Post data field name', 'singlepage' ),
			'options' =>array(
								'ID'                    => __( 'Post ID', 'singlepage' ),
								'post_author'           => __( 'Post author', 'singlepage' ),
								'post_date'             => __( 'Post date', 'singlepage' ),
								'post_date_gmt'         => __( 'Post date', 'singlepage' ) . ' GMT',
								'post_content'          => __( 'Post content', 'singlepage' ),
								'post_title'            => __( 'Post title', 'singlepage' ),
								'post_excerpt'          => __( 'Post excerpt', 'singlepage' ),
								'post_status'           => __( 'Post status', 'singlepage' ),
								'comment_status'        => __( 'Comment status', 'singlepage' ),
								'ping_status'           => __( 'Ping status', 'singlepage' ),
								'post_name'             => __( 'Post name', 'singlepage' ),
								'post_modified'         => __( 'Post modified', 'singlepage' ),
								'post_modified_gmt'     => __( 'Post modified', 'singlepage' ) . ' GMT',
								'post_content_filtered' => __( 'Filtered post content', 'singlepage' ),
								'post_parent'           => __( 'Post parent', 'singlepage' ),
								'guid'                  => __( 'GUID', 'singlepage' ),
								'menu_order'            => __( 'Menu order', 'singlepage' ),
								'post_type'             => __( 'Post type', 'singlepage' ),
								'post_mime_type'        => __( 'Post mime type', 'singlepage' ),
								'comment_count'         => __( 'Comment count', 'singlepage' )
							)
		),
		
		'default' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Default', 'singlepage' ),
			'desc' => __( 'This text will be shown if data is not found.', 'singlepage' )
		),
		'before' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Before', 'singlepage' ),
			'desc' => __( 'This content will be shown before the value.', 'singlepage' )
		),
		'after' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'After', 'singlepage' ),
			'desc' => __( 'This content will be shown after the value.', 'singlepage' )
		),
		'post_id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Post ID', 'singlepage' ),
			'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode.', 'singlepage' )
		),	
	),
	'shortcode' => '[hoo_post field="{{field}}" default="{{default}}" before="{{before}}" after="{{after}}" post_id="{{post_id}}"][/hoo_post]',
	'popup_title' => __( 'Post Data', 'singlepage' )
);


/*-----------------------------------------------------------------------------------*/
/*	Pricing Table Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['pricingtable'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Type', 'singlepage' ),
			'desc' => __( 'Select the type of pricing table', 'singlepage' ),
			'options' => array(
				'1' => 'Style 1 (Supports 5 Columns)',
				'2' => 'Style 2 (Supports 4 Columns)',
			)
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Background Color', 'singlepage' ),
			'desc' => 'Controls the background color. Leave blank for theme option selection.'
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Border Color', 'singlepage' ),
			'desc' => 'Controls the border color. Leave blank for theme option selection.'
		),
		'dividercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Divider Color', 'singlepage' ),
			'desc' => 'Controls the divider color. Leave blank for theme option selection.'
		),
		'columns' => array(
			'type' => 'select',
			'label' => __( 'Number of Columns', 'singlepage' ),
			'desc' => 'Select how many columns to display',
			'options' => array(
				'&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;' => '1 Column',
				'&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;' => '2 Columns',
				'&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;' => '3 Columns',
				'&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;' => '4 Columns',
				'&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;[pricing_column title=&quot;Standard&quot; standout=&quot;no&quot;][pricing_price currency=&quot;$&quot; currency_position=&quot;left&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][pricing_row]Feature 1[/pricing_row][pricing_footer]Signup[/pricing_footer][/pricing_column]&lt;br /&gt;' => '5 Columns'
			)
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),			
	),
	'shortcode' => '[pricing_table type="{{type}}" backgroundcolor="{{backgroundcolor}}" bordercolor="{{bordercolor}}" dividercolor="{{dividercolor}}" class="{{class}}" id="{{id}}"]{{columns}}[/pricing_table]',
	'popup_title' => __( 'Pricing Table Shortcode', 'singlepage' )
);


/*-----------------------------------------------------------------------------------*/
/*	Separator Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['separator'] = array(
	'no_preview' => true,
	'params' => array(

		'style_type' => array(
			'type' => 'select',
			'label' => __( 'Style', 'singlepage' ),
			'desc' => __( 'Choose the separator line style', 'singlepage' ),
			'options' => array(
				'none' => 'No Style',
				'single' => 'Single Border Solid',
				'double' => 'Double Border Solid',
				'single|dashed' => 'Single Border Dashed',
				'double|dashed' => 'Double Border Dashed',
				'single|dotted' => 'Single Border Dotted',
				'double|dotted' => 'Double Border Dotted',
				'shadow' => 'Shadow'
			)
		),
		'topmargin' => array(
			'std' => 40,
			'type' => 'select',
			'label' => __( 'Margin Top', 'singlepage' ),
			'desc' => __( 'Spacing above the separator', 'singlepage' ),
			'options' => hoo_shortcodes_range( 100, false, false, 0 )
		),
		'bottommargin' => array(
			'std' => 40,
			'type' => 'select',
			'label' => __( 'Margin Bottom', 'singlepage' ),
			'desc' => __( 'Spacing below the separator', 'singlepage' ),
			'options' => hoo_shortcodes_range( 100, false, false, 0 )
		),
		'sepcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Separator Color', 'singlepage' ),
			'desc' => __( 'Controls the separator color. Leave blank for theme option selection.', 'singlepage' )
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Select Icon', 'singlepage' ),
			'desc' => __( 'Click an icon to select, click again to deselect', 'singlepage' ),
			'options' => $icons
		),			
		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Separator Width', 'singlepage' ),
			'desc' => __( 'In pixels (px or %), ex: 1px, ex: 50%. Leave blank for full width.', 'singlepage' ),
		),		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),			
	),
	'shortcode' => '[separator style_type="{{style_type}}" top_margin="{{topmargin}}" bottom_margin="{{bottommargin}}"  sep_color="{{sepcolor}}" icon="{{icon}}" width="{{width}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Separator Shortcode', 'singlepage' )
);
/*-----------------------------------------------------------------------------------*/
/*	Service Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['service'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'type' => 'text',
			'label' => __( 'Title', 'singlepage' ),
			'desc' => '',
			'std' => ''
		),
		
		'link' => array(
			'std' => 'http://',
			'type' => 'text',
			'label' => __( 'Link', 'singlepage' ),
			'desc' => __( 'Read more link', 'singlepage' )
		),
		'icon_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Color', 'singlepage' ),
			'desc' => ''
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Select Icon', 'singlepage' ),
			'desc' => __( 'Click an icon to select, click again to deselect', 'singlepage' ),
			'options' => $icons
		),			
			
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Text or HTML code', 'singlepage' ),
			'desc' => __( 'Insert text or HTML code here. ', 'singlepage' ),
		),
		'icon_animation_type' => array(
			'type' => 'select',
			'label' => __( 'Icon Animation Type', 'singlepage' ),
			'desc' => '',
			'options' => $animation_type
		),
		'title_animation_type' => array(
			'type' => 'select',
			'label' => __( 'Title Animation Type', 'singlepage' ),
			'desc' => '',
			'options' => $animation_type
		),
		'content_animation_type' => array(
			'type' => 'select',
			'label' => __( 'Content Animation Type', 'singlepage' ),
			'desc' => '',
			'options' => $animation_type
		),
		'animation_duration' => array(
			'type' => 'select',
			'std' => '',
			'label' => __( 'Speed of Animation', 'singlepage' ),
			'desc' => __( 'Type in speed of animation in seconds.)', 'singlepage' ),
			'options' => $dec_numbers,
		)
		
	),
	'shortcode' => '[service title="{{title}}" icon="{{icon}}" link="{{link}}"  icon_color="{{icon_color}}" class="{{class}}" id="{{id}}" icon_animation_type="{{icon_animation_type}}" title_animation_type="{{title_animation_type}}" content_animation_type="{{content_animation_type}}" animation_duration="{{animation_duration}}"]{{content}}[/service]',
	'popup_title' => __( 'Service Shortcode', 'singlepage' )
);

/*-----------------------------------------------------------------------------------*/
/*	Social Network Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['social'] = array(
	'no_preview' => true,
	'params' => array(

		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),	
		),
	'shortcode' => '[social  class="{{class}}" id="{{id}}"]{{child_shortcode}}[/social]',
	'popup_title' => __( 'Accordion Shortcode', 'singlepage' ),
		// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
						  
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Title', 'singlepage' ),
			'desc' => ''
		),	
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Link', 'singlepage' ),
			'desc' => ''
		),	
			
			'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Select Icon', 'singlepage' ),
			'desc' => __( 'Click an icon to select, click again to deselect', 'singlepage' ),
			'options' => $icons
		)
		
           )
		,
	'shortcode' => '[social_icon title="{{title}}" link="{{link}}" icon="{{icon}}"]',
		'clone_button' => __( 'Add New Social Icon', 'singlepage')
		
		)

);

/*-----------------------------------------------------------------------------------*/
/*	Title Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['title'] = array(
	'no_preview' => true,
	'params' => array(
		'size' => array(
			'type' => 'select',
			'label' => __( 'Title Size', 'singlepage' ),
			'desc' => __( 'Choose the title size, H1-H6', 'singlepage' ),
			'options' => hoo_shortcodes_range( 6, false )
		),
		'contentalign' => array(
			'type' => 'select',
			'label' => __( 'Title Alignment', 'singlepage' ),
			'desc' => __( 'Choose to align the heading left or right.', 'singlepage' ),
			'options' => array(
				'left' => 'Left',
				'right' => 'Right'
			)
		),
		'separator' => array(
			'type' => 'select',
			'label' => __( 'Separator', 'singlepage' ),
			'desc' => __( 'Choose the kind of the title separator you want to use.', 'singlepage' ),
			'options' => array(
				'single' => 'Single',
				'double' => 'Double',
				'underline' => 'Underline',			
			)
		),			
		'sepstyle' => array(
			'type' => 'select',
			'label' => __( 'Separator Style', 'singlepage' ),
			'desc' => __( 'Choose the style of the title separator.', 'singlepage' ),
			'options' => array(
				'solid' => 'Solid',
				'dashed' => 'Dashed',
				'dotted' => 'Dotted',			
			)
		),		
		'sepcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Separator Color', 'singlepage' ),
			'desc' => __( 'Controls the separator color.  Leave blank for theme option selection.', 'singlepage')
		),		
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Title', 'singlepage' ),
			'desc' => __( 'Insert the title text', 'singlepage' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),			
	),
	'shortcode' => '[title size="{{size}}" content_align="{{contentalign}}" style_type="{{separator}} {{sepstyle}}" sep_color="{{sepcolor}}" class="{{class}}" id="{{id}}"]{{content}}[/title]',
	'popup_title' => __( 'Sharing Box Shortcode', 'singlepage' )
);

/*-----------------------------------------------------------------------------------*/
/*	Fact Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['team'] = array(
	'no_preview' => true,
	'params' => array(

		
	'avatar' => array(
			'type' => 'uploader',
			'label' => __( 'Avatar', 'singlepage' ),
			'desc' => '',
			'std' => ''
	
		),
		
	'name' => array(
			'type' => 'text',
			'label' => __( 'Name', 'singlepage' ),
			'desc' => '',
			'std' => ''
	
		),
	'byline' => array(
			'type' => 'text',
			'label' => __( 'Byline', 'singlepage' ),
			'desc' => '',
			'std' => ''
	
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		)
		,'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Text or HTML code', 'singlepage' ),
			'desc' => __( 'Insert text or HTML code here. ', 'singlepage' ),
		)
		
	),
	'shortcode' => '[team avatar="{{avatar}}" name="{{name}}"  byline="{{byline}}" class="{{class}}" id="{{id}}"]{{content}}[/team]',
	'popup_title' => __( 'Team Shortcode', 'singlepage' )
);


/*-----------------------------------------------------------------------------------*/
/*	Testimonials Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['testimonials'] = array(
	'no_preview' => true,
	'params' => array(
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Background Color', 'singlepage' ),
			'desc' => __( 'Controls the background color.  Leave blank for theme option selection.', 'singlepage' ),
		),
		'textcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __( 'Text Color', 'singlepage' ),
			'desc' => __( 'Controls the text color. Leave blank for theme option selection.', 'singlepage' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),		
	),
	'shortcode' => '[testimonials backgroundcolor="{{backgroundcolor}}" textcolor="{{textcolor}}" class="{{class}}" id="{{id}}"]{{child_shortcode}}[/testimonials]',
	'popup_title' => __( 'Insert Testimonials Shortcode', 'singlepage' ),

	'child_shortcode' => array(
		'params' => array(
			'name' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Name', 'singlepage' ),
				'desc' => __( 'Insert the name of the person.', 'singlepage' ),
			),
			'avatar' => array(
				'type' => 'select',
				'label' => __( 'Avatar', 'singlepage' ),
				'desc' => __( 'Choose which kind of Avatar to be displayed.', 'singlepage' ),
				'options' => array(
					'male' => 'Male',
					'female' => 'Female',
					'image' => 'Image',
					'none' => 'None'
				)
			),
			'image' => array(
				'type' => 'uploader',
				'label' => __( 'Custom Avatar', 'singlepage' ),
				'desc' => __( 'Upload a custom avatar image.', 'singlepage' ),
			),			
			'company' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Company', 'singlepage' ),
				'desc' => __( 'Insert the name of the company.', 'singlepage' ),
			),
			'link' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'Link', 'singlepage' ),
				'desc' => __( 'Add the url the company name will link to.', 'singlepage' ),
			),
			'target' => array(
				'type' => 'select',
				'label' => __( 'Target', 'singlepage' ),
				'desc' => __( '_self = open in same window <br />_blank = open in new window.', 'singlepage' ),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __( 'Testimonial Content', 'singlepage' ),
				'desc' => __( 'Add the testimonial content', 'singlepage' ),
			)
		),
		'shortcode' => '[testimonial name="{{name}}" avatar="{{avatar}}" image="{{image}}" company="{{company}}" link="{{link}}" target="{{target}}"]{{content}}[/testimonial]',
		'clone_button' => __( 'Add Testimonial', 'singlepage' )
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Progress Bar Config
/*-----------------------------------------------------------------------------------*/

$hoo_shortcodes['progressbar'] = array(
	'params' => array(

		'percentage' => array(
			'type' => 'select',
			'label' => __( 'Filled Area Percentage', 'singlepage' ),
			'desc' => __( 'From 1% to 100%', 'singlepage' ),
			'options' => hoo_shortcodes_range( 100, false )
		),
		'unit' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Progress Bar Unit', 'singlepage' ),
			'desc' => __( 'Insert a unit for the progress bar. ex %', 'singlepage' ),
		),
		'filledcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Filled Color', 'singlepage' ),
			'desc' => __( 'Controls the color of the filled in area. Leave blank for theme option selection.', 'singlepage' )
		),
		'unfilledcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Unfilled Color', 'singlepage' ),
			'desc' => __( 'Controls the color of the unfilled in area. Leave blank for theme option selection.', 'singlepage' )
		),
		'striped' => array(
			'type' => 'select',
			'label' => __( 'Striped Filling', 'singlepage' ),
			'desc' => __( 'Choose to get the filled area striped.', 'singlepage' ),
			'options' => $reverse_choices
		),
		'animatedstripes' => array(
			'type' => 'select',
			'label' => __( 'Animated Stripes', 'singlepage' ),
			'desc' => __( 'Choose to get the the stripes animated.', 'singlepage' ),
			'options' => $reverse_choices
		),			
		'textcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Text Color', 'singlepage' ),
			'desc' => __( 'Controls the text color. Leave blank for theme option selection.', 'singlepage')
		),
		'content' => array(
			'std' => __('Text', 'singlepage'),
			'type' => 'text',
			'label' => __( 'Progess Bar Text', 'singlepage' ),
			'desc' => __( 'Text will show up on progess bar', 'singlepage' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'singlepage' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'singlepage' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'singlepage' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'singlepage' )
		),		
	),
	'shortcode' => '[progress percentage="{{percentage}}" unit="{{unit}}" filledcolor="{{filledcolor}}" unfilledcolor="{{unfilledcolor}}" striped="{{striped}}" animated_stripes="{{animatedstripes}}" textcolor="{{textcolor}}" class="{{class}}" id="{{id}}"]{{content}}[/progress]',
	'popup_title' => __( 'Progress Bar Shortcode', 'singlepage' ),
	'no_preview' => true,
);