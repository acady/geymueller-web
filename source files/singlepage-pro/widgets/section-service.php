<?php

class Singlepage_Service extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'singlepage_service_widget', 'description' => '' );
        parent::__construct(false, $name = __('Singlepage: Service', 'singlepage'), $widget_ops);
		$this->alt_option_name = 'singlepage_service_widget';
		 add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
    }
	
	
	 /**
     * Upload the Javascripts for the media uploader
     */
    public function upload_scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('upload_media_widget',  get_template_directory_uri() . '/js/upload-media.js', array('jquery'));
        wp_enqueue_style('thickbox');
    }
	
	function form($instance) {
		$icon     			= isset( $instance['icon'] ) ? esc_attr( $instance['icon'] ) : '';
		$title     			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';		
		$image  		    = isset( $instance['image'] ) ? esc_url( $instance['image'] ) : '';
		$description        = isset( $instance['description'] ) ? esc_textarea( $instance['description'] ) : '';
		$link 	            = isset( $instance['link'] ) ? esc_url( $instance['link'] ) : '';
		$font_color 	    = isset( $instance['font_color'] ) ? esc_url( $instance['font_color'] ) : '';
		
	?>
    
    <p>
    <label for="<?php echo $this->get_field_id( 'font_color' ); ?>" style="display:block;"><?php _e( 'Font Color:', 'singlepage'); ?></label> 
    <input class="widefat sp-color-picker" id="<?php echo $this->get_field_id( 'font_color' ); ?>" name="<?php echo $this->get_field_name( 'font_color' ); ?>" type="text" value="<?php echo esc_attr( $font_color ); ?>" />
</p>

	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'singlepage'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
	
    <p><label for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Icon', 'singlepage'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('icon'); ?>" name="<?php echo $this->get_field_name('icon'); ?>" type="text" value="<?php echo $icon; ?>" /></p>
    <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image', 'singlepage' ); ?></label>
            <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            <input class="upload_image_button" type="button" value="<?php _e('Upload Image', 'singlepage'); ?>" />
        </p>
        
         <p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link', 'singlepage'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" /></p>
    <p>
        
         <p>
            <label for="<?php echo $this->get_field_id( 'description'  ); ?>"><?php _e('Description', 'singlepage'); ?></label>
            <textarea id="<?php echo $this->get_field_id( 'description'  ); ?>"  name="<?php echo $this->get_field_name( 'description'  ); ?>" class="widefat" ><?php echo $description; ?></textarea>
            </p>
        
	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			 = strip_tags($new_instance['title']);
		$instance['image']           = esc_url_raw($new_instance['image']);
		$instance['link']            = esc_url_raw($new_instance['link']);

		if ( current_user_can('unfiltered_html') ) {
			$instance['description'] = $new_instance['description'];
		} else {
			$instance['description'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['description']) ) );
		}			

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['singlepage_action']) )
			delete_option('singlepage_action');		  
		  
		return $instance;
	}
	
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'singlepage_action', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title 			 = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 			 = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$icon 	         = isset( $instance['icon'] ) ? esc_attr($instance['icon']) : '';
		$image           = isset( $instance['image'] ) ? esc_url($instance['image']) : '';
		$link            = isset( $instance['link'] ) ? esc_url($instance['link']) : '';
		$description 	 = isset( $instance['description'] ) ? $instance['description'] : '';
		echo $args['before_widget'];
		
		$service_icon = '';
		if( $icon != '' )
		$service_icon = '<i class="fa '.$icon.'"></i>';
		if( $image != '' )
		$service_icon = '<img src="'.$image.'" alt="'.$title.'" />';
?>
      <div class="service-item widget-service">
      <?php if ($link !='') : ?>
      <a class="service-link" href="<?php echo $link;?>">
      <?php endif; ?>
       <?php echo $service_icon;?>
        <h3 class="service-title"><?php echo $title;?></h3>
        <p class="service-desc"><?php echo $description;?></p>
        <?php if ($link !='') : ?>
      </a>
      <?php endif; ?>
    </div>
    
	<?php
		echo $args['after_widget'];

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'singlepage_action', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}