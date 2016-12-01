<?php
class Hoo_Contact {

	public static $args;
	public static $parent_args;
    public static $child_args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'contact_form', array( $this, 'render_parent' ) );
        add_shortcode( 'contact_form_field', array( $this, 'render_child' ) );
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
				'id' =>'singlepage-contact-form',
				'class' =>'',
				'receiver_email' =>'',
				'color' =>'',
				'border_color' =>'',
				'button_text' => __( 'Send It', 'singlepage' ),
			
			), $args
		);
        
		extract( $defaults );
		self::$parent_args = $defaults;
	    $form_id = uniqid('webform-client-form-');
		
		
		$html = '<div class="singlepage-shortcode singlepage-contact-form contact-form '.esc_attr($class).'" id="'.esc_attr($id).'">
		<form class="webform-client-form contact-form '.$form_id.'" onsubmit="return false;" enctype="multipart/form-data" action="'.esc_url(home_url('/')).'" method="post" id="'.$form_id.'" accept-charset="UTF-8">
 <fieldset>
		'.do_shortcode( singlepage_fix_shortcodes($content)).'
		 </fieldset>
		    <div class="form-actions" style="width:50%;">
      <input class="webform-submit button-primary form-submit ajax-processed" type="submit" name="op" value="'.$button_text.'">
    </div>
	 <input type="hidden" id="receiver_email" name="contact[receiver_email]" value="'.base64_encode($receiver_email).'">
  
</form>
		</div>';

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
				'type' =>'',
				'placeholder' =>'',
				'width' =>'',
				'required' =>'',
			
			), $args
		);

		extract( $defaults );
		self::$child_args = $defaults;
		
	$wrap_css_style = '';
	if( $width == 'half' )
	$wrap_css_style = 'width:50%;';
	
	
	$field_css_style = '';
	if( self::$parent_args['color'] )
	$field_css_style .= 'color:'.self::$parent_args['color'].';';
	if( self::$parent_args['border_color'] )
	$field_css_style .= 'border-color:'.self::$parent_args['border_color'].';';
	
	
	$required_class ='';
	$required_str = '';
	$field_id = uniqid('field_');
	if(  $required == 'yes' ){
	$required_class = 'required';
    $required_str   = 'required="required" aria-required="true"';
	}
	
	switch($type){
	case 'textarea':
	
	$html ='<div class="form-item webform-component webform-component-textarea " style="'.$wrap_css_style.'">
         <div class="form-textarea-wrapper">
        <textarea placeholder="'.$placeholder.'" style="'.$field_css_style.'" name="contact['.$field_id.']" cols="60" rows="5" class="form-textarea '.$required_class.'" '.$required_str.'></textarea>
      </div>
    </div>';
	break;
	case 'text':
		
		$html ='<div class="form-item webform-component webform-component-textfield" style="'.$wrap_css_style.'">
      <input placeholder="'.$placeholder.'" style="'.$field_css_style.'"  type="text" name="contact['.$field_id.']" value="" size="60" maxlength="128" class="form-text '.$required_class.'" '.$required_str.'>
    </div>';
	break;
	case 'email':
	$html ='<div class="form-item webform-component webform-component-textfield" style="'.$wrap_css_style.'">
      <input placeholder="'.$placeholder.'" style="'.$field_css_style.'" type="email" name="contact['.$field_id.']" value="" size="60" maxlength="128" class="form-text '.$required_class.'" '.$required_str.'>
    </div>';
	break;
		
	}
	
		return $html;
	}


}

new Hoo_Contact();