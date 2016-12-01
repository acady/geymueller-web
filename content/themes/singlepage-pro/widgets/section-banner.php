<?php

class Singlepage_Banner extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'singlepage_banner_widget', 'description' => '' );
        parent::__construct(false, $name = __('Singlepage: Banner', 'singlepage'), $widget_ops);
		$this->alt_option_name = 'singlepage_banner_widget';
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

		for( $i=0;$i<5;$i++):
		
		$image[$i]       = isset( $instance['image_'.$i] ) ? esc_url( $instance['image_'.$i] ) : '';
		$description[$i] = isset( $instance['description_'.$i] ) ? esc_textarea( $instance['description_'.$i] ) : '';
		
	?>
    
    <p>
            <label for="<?php echo $this->get_field_name( 'image_'.$i ); ?>"><?php printf(__( 'Image %d' , 'singlepage'),($i+1)); ?></label>
            <input name="<?php echo $this->get_field_name( 'image_'.$i ); ?>" id="<?php echo $this->get_field_id( 'image_'.$i ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image[$i] ); ?>" />
            <input class="upload_image_button" type="button" value="<?php _e('Upload Image', 'singlepage'); ?>" />
        </p>

         <p>
            <label for="<?php echo $this->get_field_id( 'description_'.$i ); ?>"><?php printf(__('Description %d', 'singlepage'),($i+1)); ?></label>
            <textarea id="<?php echo $this->get_field_id( 'description_'.$i  ); ?>"  name="<?php echo $this->get_field_name( 'description_'.$i  ); ?>" class="widefat" ><?php echo $description[$i]; ?></textarea>
            </p>
        
	<?php
	endfor;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		for( $i=0;$i<5;$i++):
		
		$instance['image_'.$i] = esc_url_raw($new_instance['image_'.$i]);

		if ( current_user_can('unfiltered_html') ) {
			$instance['description_'.$i] = $new_instance['description_'.$i];
		} else {
			$instance['description_'.$i] = stripslashes( wp_filter_post_kses( addslashes($new_instance['description_'.$i]) ) );
		}			
		endfor;

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
		
		$slider_id  = uniqid('carousel');
		$indicators = '';
		$item       = '';

		echo $args['before_widget'];
		
		$return = '<div id="'.$slider_id.'" class="carousel slide" data-ride="carousel">';
		for( $i=0;$i<5;$i++):
		$active = '';
		if( $i==0 )
		$active = 'active';
		
		$image       = isset($instance['image_'.$i])?$instance['image_'.$i]:'';
		$description = isset($instance['description_'.$i])?$instance['description_'.$i]:'';
		if( $image !='' ):
		
		$indicators .= '<li data-target="#'.$slider_id.'" data-slide-to="'.$i.'" class="'.$active.'"></li>';
		$item       .= '<div class="item '.$active.'">
          <img src="'.$image.'" alt="">
          <div class="container">
            <div class="carousel-caption">
              '.$description.'
            </div>
          </div>
        </div>
';
       endif;
		
		endfor;
		
		$return .= '<ol class="carousel-indicators">'.$indicators.'</ol>';
		$return .= '<div class="carousel-inner" role="listbox">'.$item.'</div>';
		$return .= '</div>';
		
		echo $return;

		echo $args['after_widget'];

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'singlepage_action', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}