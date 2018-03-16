<?php


/*
*  page navigation
*
*/
function singlepage_native_pagenavi($echo,$wp_query){
    if(!$wp_query){global $wp_query;}
    global $wp_rewrite;      
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
    'base' => @add_query_arg('paged','%#%'),
    'format' => '',
    'total' => $wp_query->max_num_pages,
    'current' => $current,
    'prev_text' => '&laquo; ',
    'next_text' => ' &raquo;'
    );
 
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
 
    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array('s'=>get_query_var('s'));
    if($echo == "echo"){
        echo '<div class="page_navi">'.paginate_links($pagination).'</div>'; 
	}else
	{
	
	return '<div class="page_navi">'.paginate_links($pagination).'</div>';
	}
}


/*
*  Custom comments list
*
*/
   
  function singlepage_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ;?>">
     <div id="comment-<?php comment_ID(); ?>">
	 
	 <div class="comment-avatar"><?php echo get_avatar($comment,'52','' ); ?></div>
			<div class="comment-info">
			<div class="reply-quote">
             <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ;?>
			</div>
      <div class="comment-author vcard">
        
			<span class="fnfn"><?php printf(__('<cite> %s </cite><span class="says">says:</span>','singlepage'), get_comment_author_link()) ;?></span>
								<span class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ;?>">
<?php printf(__('%1$s at %2$s','singlepage'), get_comment_date(), get_comment_time()) ;?></a>
<?php edit_comment_link(__('(Edit)','singlepage'),'  ','') ;?></span>
				<span class="comment-meta">
					<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ;?>">-#<?php echo $depth?></a>				</span>

      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.','singlepage') ;?></em>
         <br />
      <?php endif; ?>

     

      <?php comment_text() ;?>
</div>
   <div class="clear"></div>
     </div>
<?php
        }
		
	/*
*  wp_title filter
*
*/	
if ( ! function_exists( '_wp_render_title_tag' ) ) {		
 function singlepage_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( ' Page %s ', 'singlepage' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'singlepage_wp_title', 10, 2 );
}


if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function singlepage_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'singlepage_slug_render_title' );
}
/*
*  title filter
*
*/

function singlepage_the_title( $title ) {
if ( $title == '' ) {
  return 'Untitled';
  } else {
  return $title;
  }
}
add_filter( 'the_title', 'singlepage_the_title' );




   /**
 * sp admin sidebar
 */
 
//add_action( 'optionsframework_sidebar','singlepage_options_panel_sidebar' );

function singlepage_options_panel_sidebar() { ?>
	<div id="optionsframework-sidebar">
		<div class="metabox-holder">
	    	<div class="postbox">
	    		<h3><?php _e( 'Quick Links', 'singlepage' ); ?></h3>
      			<div class="inside"> 
		          <ul>
                  <li><a href="<?php echo esc_url( 'http://www.hoosoft.com/themes/single-page.html' ); ?>" target="_blank"><?php _e( 'SinglePage Theme', 'singlepage' ); ?></a></li>
                  <li><a href="<?php echo esc_url( 'http://www.hoosoft.com/singlepage-wordpress-theme-manual.html' ); ?>" target="_blank"><?php _e( 'Tutorials', 'singlepage' ); ?></a></li>
                  </ul>
      			</div>
	    	</div>
	  	</div>
	</div>
    <div class="clear"></div>
<?php
}


/*	
*	get background 
*	---------------------------------------------------------------------
*/
function singlepage_get_background($args){
$background = "";
 if ( is_array($args) && $args ) {
	if (isset($args['image']) && $args['image']!="") {
	$background .=  "background:url(".$args['image']. ")  ".$args['repeat']." ".$args['position']." ".$args['attachment'].";";
	}
	if(isset($args['color']) && $args['color'] !=""){
	$background .= "background-color:".$args['color'].";";
	}
	}
return $background;
}


// allow script & iframe tag within posts
function singlepage_allow_post_tags( $allowedposttags ){
    $allowedposttags['script'] = array(
        'type' => true,
        'src' => true,
        'height' => true,
        'width' => true,
    );
    $allowedposttags['iframe'] = array(
        'src' => true,
        'width' => true,
        'height' => true,
        'class' => true,
        'frameborder' => true,
        'webkitAllowFullScreen' => true,
        'mozallowfullscreen' => true,
        'allowFullScreen' => true
    );
	
	$allowedposttags["embed"] = array(
	   "src" => true,
	   "type" => true,
	   "allowfullscreen" => true,
	   "allowscriptaccess" => true,
	   "height" => true,
	   "width" => true
	  );
	
    return $allowedposttags;
}
add_filter('wp_kses_allowed_html','singlepage_allow_post_tags', 1);


 /**
 * singlepage favicon
 */

	function singlepage_favicon()
	{
	    $url =  of_get_option('favicon');
	
		$icon_link = "";
		if($url)
		{
			$type = "image/x-icon";
			if(strpos($url,'.png' )) $type = "image/png";
			if(strpos($url,'.gif' )) $type = "image/gif";
		
			$icon_link = '<link rel="icon" href="'.esc_url($url).'" type="'.$type.'">';
		}
		
		echo $icon_link;
	}
	
	 add_action( 'wp_head', 'singlepage_favicon' );



   function singlepage_get_typography($value){
   $return = "";
   if ( is_array($value) && singlepage_array_keys_exists( $value, array( 'font-color', 'font-family', 'font-size', 'font-style', 'font-variant', 'font-weight', 'letter-spacing', 'line-height', 'text-decoration', 'text-transform' ) ) ) {
          $font = array();
          
          if ( ! empty( $value['font-color'] ) )
            $font[] = "color: " . $value['font-color'] . ";";
          
          if ( ! empty( $value['font-family'] ) ) {
                $font[] = "font-family: " . $value['font-family'] . ";";
          }
          
          if ( ! empty( $value['font-size'] ) )
            $font[] = "font-size: " . $value['font-size'] . ";";
          
          if ( ! empty( $value['font-style'] ) )
            $font[] = "font-style: " . $value['font-style'] . ";";
          
          if ( ! empty( $value['font-variant'] ) )
            $font[] = "font-variant: " . $value['font-variant'] . ";";
          
          if ( ! empty( $value['font-weight'] ) )
            $font[] = "font-weight: " . $value['font-weight'] . ";";
            
          if ( ! empty( $value['letter-spacing'] ) )
            $font[] = "letter-spacing: " . $value['letter-spacing'] . ";";
          
          if ( ! empty( $value['line-height'] ) )
            $font[] = "line-height: " . $value['line-height'] . ";";
          
          if ( ! empty( $value['text-decoration'] ) )
            $font[] = "text-decoration: " . $value['text-decoration'] . ";";
          
          if ( ! empty( $value['text-transform'] ) )
            $font[] = "text-transform: " . $value['text-transform'] . ";";
          
          /* set $value with font properties or empty string */
          $return = ! empty( $font ) ? implode( " ", $font ) : '';

        } 
		return $return;
		}
		
function singlepage_array_keys_exists( $array, $keys ) {
  
  foreach( $keys as $k )
    if ( isset( $array[$k] ) )
      return true;
  
  return false;
  
}


 /*	
*	 Fixed shortcode
*/

 function singlepage_fix_shortcodes($content){   
			$replace_tags_from_to = array (
				'<p>[' => '[', 
				']</p>' => ']', 
				']<br />' => ']',
				']<br>' => ']',
				']\r\n' => ']',
				']\n' => ']',
				']\r' => ']',
				'\r\n[' => '[',
			);

			return strtr( $content, $replace_tags_from_to );
		}

 function singlepage_the_content_filter($content) {
	  $content = singlepage_fix_shortcodes($content);
	  return $content;
	}
	
add_filter( 'the_content', 'singlepage_the_content_filter' );


//add a button to the content editor, next to the media button
//this button will show a popup that contains inline content
add_action('media_buttons_context', 'singlepage_add_my_custom_button');


//action to add a custom button to the content editor
function singlepage_add_my_custom_button($context) {
  
  //path to my icon
  $img = get_template_directory_uri() .'/images/shortcode.png';
  
 
  //our popup's title
  $title = __('Singlepage Shortcodes','singlepage');

  //append the icon
  $context .= "<a class='singlepage_shortcodes button' title='{$title}'><img src='{$img}' />".$title."</a>";
  
  return $context;
}


// filter radio image
 function singlepage_filter_radio_images( $array, $field_id ) {


  if($field_id == "page_layout"){
	  
	   $array = array(
      array(
        'value'   => 'left-sidebar',
        'label'   => __( 'Left Sidebar', 'singlepage' ),
        'src'     => get_template_directory_uri() . '/option-tree/assets/images/layout/left-sidebar.png'
      ),
      array(
        'value'   => 'right-sidebar',
        'label'   => __( 'Right Sidebar', 'singlepage' ),
         'src'     => get_template_directory_uri() . '/option-tree/assets/images/layout/right-sidebar.png'
      ),
	  array(
        'value'   => 'full-width',
        'label'   => __( 'Full Width', 'singlepage' ),
        'src'     => get_template_directory_uri() . '/option-tree/assets/images/layout/full-width.png'
      ),
	  
    );
	  }
  

  return $array;

}
add_filter( 'ot_radio_images', 'singlepage_filter_radio_images', 10, 2 );


//** fonts **//

/**

* Returns an array of system fonts

* Feel free to edit this, update the font fallbacks, etc.

*/



function singlepage_options_typography_get_os_fonts() {

  // OS Font Defaults

  $os_faces = array(

      'Arial, sans-serif' => 'Arial',

      '"Avant Garde", sans-serif' => 'Avant Garde',

      'Cambria, Georgia, serif' => 'Cambria',

      'Copse, sans-serif' => 'Copse',

      'Garamond, "Hoefler Text", Times New Roman, Times, serif' => 'Garamond',

      'Georgia, serif' => 'Georgia',

      '"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica Neue',

      'Tahoma, Geneva, sans-serif' => 'Tahoma'

  );

  return $os_faces;

}


/**

* Returns a select list of Google fonts

* Feel free to edit this, update the fallbacks, etc.

*/



function singlepage_options_typography_get_google_fonts() {

  // Google Font Defaults
  global $google_fonts;
  get_template_part('includes/google','fonts');
  $google_faces = array();
 if( $google_fonts )
 {
	 
	 $google_fonts = json_decode( $google_fonts, true );
	if( isset($google_fonts['items']) ){
		foreach( $google_fonts['items'] as $google_fonts ){
			
			$family   = $google_fonts['family'];
			$category = isset( $google_fonts['category'])?', '.$google_fonts['category']:'';
			$google_faces[$family.$category] = $family;
			
			}
		}
	 
	 }


  return $google_faces;

}



/**

* Checks font options to see if a Google font is selected.

* If so, options_typography_enqueue_google_font is called to enqueue the font.

* Ensures that each Google font is only enqueued once.

*/

 


  function singlepage_options_typography_google_fonts() {

      $all_google_fonts = array_keys( singlepage_options_typography_get_google_fonts() );

      // Define all the options that possibly have a unique Google font



      $page_menu_typography                = of_get_option('page_menu_typography', false);
	  $blog_menu_typography                = of_get_option('blog_menu_typography', false);
	  $homepage_side_nav_menu_typography   = of_get_option('homepage_side_nav_menu_typography', false);
	  $homepage_section_content_typography = of_get_option('homepage_section_content_typography', false);
	  $page_post_content_typography        = of_get_option('page_post_content_typography', false);
      $sectionNum                 = of_get_option('section_num', 4);
	  
	  $section_content_typography_array   = array();
	  if(  $sectionNum > 0 ) { 
		    for( $i=0; $i<$sectionNum; $i++ ){ 
			   $section_content_typography           = of_get_option('section_content_typography_'.$i, false);
			   if(isset($section_content_typography['face'])){
			   $section_content_typography_array[$i] = $section_content_typography['face'];
			   }
			  }
			}

      // Get the font face for each option and put it in an array

      $selected_fonts = array(


          $page_menu_typography['face'],
		  $blog_menu_typography['face'],
		  $homepage_side_nav_menu_typography['face'],
		  $homepage_section_content_typography['face'],
		  $page_post_content_typography['face'],
 );
	  if( $section_content_typography_array ){
		 $selected_fonts = array_merge($selected_fonts , $section_content_typography_array);
		  }

      // Remove any duplicates in the list

      $selected_fonts = array_unique($selected_fonts);

      // Check each of the unique fonts against the defined Google fonts

      // If it is a Google font, go ahead and call the function to enqueue it

      foreach ( $selected_fonts as $font ) {

          if ( in_array( $font, $all_google_fonts ) ) {

              singlepage_options_typography_enqueue_google_font($font);

          }

      }
  }


add_action( 'wp_enqueue_scripts', 'singlepage_options_typography_google_fonts' );

/**

 * Enqueues the Google $font that is passed

 */

function singlepage_options_typography_enqueue_google_font($font) {

  $font = explode(',', $font);

  $font = $font[0];

  // Certain Google fonts need slight tweaks in order to load properly

  // Like our friend "Raleway"

  if ( $font == 'Raleway' )

      $font = 'Raleway:100';

  $font = str_replace(" ", "+", $font);

  wp_enqueue_style( "singlepage_options_typography_$font", esc_url("//fonts.googleapis.com/css?family=$font"), false, null, 'all' );

}


/*

* Returns a typography option in a format that can be outputted as inline CSS

*/

 
function singlepage_options_typography_font_styles($option, $selectors) {

      $output = $selectors . ' {';

      $output .= ' color:' . $option['color'] .'; ';

      $output .= 'font-family:' . $option['face'] . '; ';

      $output .= 'font-weight:' . $option['style'] . '; ';

      $output .= 'font-size:' . $option['size'] . '; ';

      $output .= '}';

      $output .= "\n";

      return $output;

}

function singlepage_options_typography_font_styles2($option) {

      $output = '';
	
      $output .= ' color:' . $option['color'] .'; ';

      $output .= 'font-family:' . $option['face'] . '; ';

      $output .= 'font-weight:' . $option['style'] . '; ';

      $output .= 'font-size:' . $option['size'] . '; ';


      return $output;

}


function singlepage_rgb2hsl( $hex_color ) {

	$hex_color	= str_replace( '#', '', $hex_color );

	if( strlen( $hex_color ) < 3 ) {
		str_pad( $hex_color, 3 - strlen( $hex_color ), '0' );
	}

	$add		 = strlen( $hex_color ) == 6 ? 2 : 1;
	$aa		  = 0;
	$add_on	  = $add == 1 ? ( $aa = 16 - 1 ) + 1 : 1;

	$red		 = round( ( hexdec( substr( $hex_color, 0, $add ) ) * $add_on + $aa ) / 255, 6 );
	$green	   = round( ( hexdec( substr( $hex_color, $add, $add ) ) * $add_on + $aa ) / 255, 6 );
	$blue		= round( ( hexdec( substr( $hex_color, ( $add + $add ) , $add ) ) * $add_on + $aa ) / 255, 6 );

	$hsl_color	= array( 'hue' => 0, 'sat' => 0, 'lum' => 0 );

	$minimum	 = min( $red, $green, $blue );
	$maximum	 = max( $red, $green, $blue );

	$chroma	  = $maximum - $minimum;

	$hsl_color['lum'] = ( $minimum + $maximum ) / 2;

	if( $chroma == 0 ) {
		$hsl_color['lum'] = round( $hsl_color['lum'] * 100, 0 );

		return $hsl_color;
	}

	$range = $chroma * 6;

	$hsl_color['sat'] = $hsl_color['lum'] <= 0.5 ? $chroma / ( $hsl_color['lum'] * 2 ) : $chroma / ( 2 - ( $hsl_color['lum'] * 2 ) );

	if( $red <= 0.004 || 
		$green <= 0.004 || 
		$blue <= 0.004 
	) {
		$hsl_color['sat'] = 1;
	}

	if( $maximum == $red ) {
		$hsl_color['hue'] = round( ( $blue > $green ? 1 - ( abs( $green - $blue ) / $range ) : ( $green - $blue ) / $range ) * 255, 0 );
	} else if( $maximum == $green ) {
		$hsl_color['hue'] = round( ( $red > $blue ? abs( 1 - ( 4 / 3 ) + ( abs ( $blue - $red ) / $range ) ) : ( 1 / 3 ) + ( $blue - $red ) / $range ) * 255, 0 );
	} else {
		$hsl_color['hue'] = round( ( $green < $red ? 1 - 2 / 3 + abs( $red - $green ) / $range : 2 / 3 + ( $red - $green ) / $range ) * 255, 0 );
	}

	$hsl_color['sat'] = round( $hsl_color['sat'] * 100, 0 );
	$hsl_color['lum']  = round( $hsl_color['lum'] * 100, 0 );

	return $hsl_color;
}

function singlepage_process_tag( $m ) {
   if ($m[2] == 'dropcap' || $m[2] == 'highlight' || $m[2] == 'tooltip') {
      return $m[0];
   }

	// allow [[foo]] syntax for escaping a tag
	if ( $m[1] == '[' && $m[6] == ']' ) {
		return substr($m[0], 1, -1);
	}

   return $m[1] . $m[6];
}




// get related portfolios
 function singlepage_get_related_portfolios($postid,$num = 4){
	
	if ( 'singlepage_portfolio' == get_post_type() ) {
	$taxs = wp_get_post_terms( $postid, 'portfolio_tags' );

	if ( $taxs ) {
		$tax_ids = array();
		foreach( $taxs as $individual_tax ) $tax_ids[] = $individual_tax->term_id;
	$args = array(
	'tax_query' => array(
		array(
			'taxonomy'  => 'portfolio_tags',
			'terms' 	=> $tax_ids,
			'operator'  => 'IN'
		)
	),
	'post__not_in' 			=> array( $postid ),
	'posts_per_page' 		=> $num,
	'ignore_sticky_posts' 	=> 1
     );
		
		$my_query = new WP_Query( $args );
		$result = "";
	    $return = "";
        $i      = 1;
		if( $my_query->have_posts() ) {
			while ( $my_query->have_posts() ) :
				  
         $my_query->the_post();  
         $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'portfolio');
		 $featured_large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
		 $thumb = "";
		 if($featured_image[0] !=""){
			 
			$return .= '<article class="col-md-3 portfolio-item"><span>
                <img src="'.$featured_image[0].'" alt="photo">
                <div class="da-animate da-slideFromTop" style="display: block;">
                    <a href="'.$featured_large[0].'" rel="prettyPhoto" class="p-view"></a>
                    <a href="'.get_permalink().'" class="p-link"></a>
                </div></span>
            </article>';
			
			
		
	 if($i % 4 == 0){
	      $return .= '<div class="row">'.$result.'</div>';
		  $result  = "";
		 }
		 $i++;
			 }
			endwhile; 
            wp_reset_postdata();
			 return $return.'<div class="row">'.$result.'</div>' ;
		}
		else{
			 
			return __('No related project found',"singlepage");
			wp_reset_postdata();
			}
		}
	else{
		return __('No related project found',"singlepage");
		}
}

}

// import options
 function singlepage_import_options(){
	 
	 $options = $_POST['options']; 

	 if( $options ){
	 $options       =  base64_decode($options);
	 $options_array = unserialize(stripslashes($options));
	 if( is_array($options_array) ){
	 update_option(optionsframework_option_name() ,$options_array);
	 }
	 }
	 exit(0);
	 }
 add_action('wp_ajax_singlepage_import_options', 'singlepage_import_options');
 add_action('wp_ajax_nopriv_singlepage_import_options', 'singlepage_import_options');
 
 // Contact form send Email
 function singlepage_contact(){


    $body  = '';
	$email = '';
	 if (isset($_POST['your_email']) && preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim(base64_decode($_POST['your_email'])))) {
		 $email = $_POST['your_email'];
	 }
	
	   if (isset($_POST['sendto']) && preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim(base64_decode($_POST['sendto'])))) {
	     $emailTo = base64_decode($_POST['sendto']);
	   }
	   else{
	 	 $emailTo = get_option('admin_email');
	   }

		 if($emailTo !=""){
		$subject = 'From '.get_bloginfo('name');
		
		parse_str($_POST['values'], $values);

		if( is_array($values) ){
		foreach( $values as $k => $v ){
			if( $k !=='sendto' )
			$body .= str_replace('_',' ',$k).': '.$v.' <br/><hr><br/>';
			if( $email =='' && strpos(strtolower($k),'email') && $v != "" ){
				$email = $v;
				}
			}
		}
	
		$headers = 'From: '.get_bloginfo('name').' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email . "\r\n";	
		
		$headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
		wp_mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
		}
		echo json_encode(array("msg"=>__("Your message has been successfully sent!","singlepage"),"error"=>0));
		
	die() ;
	}
	add_action('wp_ajax_singlepage_contact', 'singlepage_contact');
	add_action('wp_ajax_nopriv_singlepage_contact', 'singlepage_contact');
	


// Convert Hex Color to RGB 
/* function singlepage_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return $rgb; 
}*/


function singlepage_get_post_meta_key($key, $ID = 0, $default = ''){
	if($ID == 0){ $ID = get_the_ID(); }
	if($ID <= 0){ return $default;}
	$result = get_post_meta($ID , $key , true);
	if($result){ return $result; }
	return $default;
}

/**
 * Convert Hex Code to RGB
 * @param  string $hex Color Hex Code
 * @return array       RGB values
 */
 
function singlepage_hex2rgb( $hex ) {
		if ( strpos( $hex,'rgb' ) !== FALSE ) {

			$rgb_part = strstr( $hex, '(' );
			$rgb_part = trim($rgb_part, '(' );
			$rgb_part = rtrim($rgb_part, ')' );
			$rgb_part = explode( ',', $rgb_part );

			$rgb = array($rgb_part[0], $rgb_part[1], $rgb_part[2], $rgb_part[3]);

		} elseif( $hex == 'transparent' ) {
			$rgb = array( '255', '255', '255', '0' );
		} else {

			$hex = str_replace( '#', '', $hex );

			if( strlen( $hex ) == 3 ) {
				$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
				$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
				$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
			} else {
				$r = hexdec( substr( $hex, 0, 2 ) );
				$g = hexdec( substr( $hex, 2, 2 ) );
				$b = hexdec( substr( $hex, 4, 2 ) );
			}
			$rgb = array( $r, $g, $b );
		}

		return $rgb; // returns an array with the rgb values
	}


// Code before </head>

 function singlepage_code_before_head(){
	 
   $code_before_head = of_get_option('header_code');
   echo $code_before_head;
   
 } 

add_action('wp_head', 'singlepage_code_before_head'); 


 // Code before </body>
	
 function singlepage_code_before_body(){
	 
   $code_before_body = of_get_option('footer_code');
   echo $code_before_body;
   
 } 

add_action('wp_footer', 'singlepage_code_before_body'); 