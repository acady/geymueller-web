<?php
class Hoo_ImageCarousel {
  public static $args;
	private $image_carousel_counter = 1;

    public static $parent_args;
    public static $child_args;

    /**
     * Initiate the shortcode
     */
    public function __construct() {

        add_filter( 'hoo_attr_image-carousel-shortcode', array( $this, 'attr' ) );
        add_filter( 'hoo_attr_image-carousel-shortcode-slide-link', array( $this, 'slide_link_attr' ) );

        add_shortcode( 'imagecarousel', array( $this, 'render_parent' ) );
        add_shortcode( 'image', array( $this, 'render_child' ) );

    }

    /**
     * Render the parent shortcode
     * @param  array $args    Shortcode paramters
     * @param  string $content Content between shortcode
     * @return string          HTML output
     */
    function render_parent( $args, $content = '') {

        $defaults = HooCore_Plugin::set_shortcode_defaults(
        	array(
                'items' => '4',
				'class'		=> '',
				'id'		=> ''
				

        ), $args );
		
		

        extract( $defaults );

        self::$parent_args = $defaults;
        
		$html = sprintf( '<div %s><div %s><div %s>%s</div><div %s><span %s></span><span %s></span></div></div></div>', 
						 HooCore_Plugin::attributes( 'image-carousel-shortcode' ), HooCore_Plugin::attributes( 'ot-carousel-wrapper singlepage-carousel' ), 
						 HooCore_Plugin::attributes( 'ot-carousel' ), do_shortcode($content), HooCore_Plugin::attributes( 'ot-nav' ),
						 HooCore_Plugin::attributes( 'ot-nav-prev' ), HooCore_Plugin::attributes( 'ot-nav-next' ) );        

		$this->image_carousel_counter++;

        return $html;

    }

    function attr() {

        $attr = array();

        $attr['class'] = 'images-carousel-container singlepage-image-carousel';
       
            $attr['data-items'] = self::$parent_args['items'];

        if( self::$parent_args['class'] ) {
            $attr['class'] .= ' ' . self::$parent_args['class']; 
        }

        if( self::$parent_args['id'] ) {
            $attr['id'] = self::$parent_args['id']; 
        }

        return $attr;

    }


    /**
     * Render the child shortcode
     * @param  array $args     Shortcode paramters
     * @param  string $content Content between shortcode
     * @return string          HTML output
     */
    function render_child( $args, $content = '') {

        $defaults = HooCore_Plugin::set_shortcode_defaults(
        	array(       	
				'alt'        	=> '',
	            'image'      	=> '',				
	            'link'       	=> '',
	            'linktarget' 	=> '_self',
        	), $args 
        );

        extract( $defaults );

        self::$child_args = $defaults;
        
		$image_id = HooCore_Plugin::get_attachment_id_from_url( $image );

		if( ! $alt && empty( $alt ) && $image_id ) {
			self::$child_args['alt'] = $alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		}
		
		if( $image_id ) {
			self::$child_args['title_attr'] = get_post_field( 'post_excerpt', $image_id );
		}
		
        $output = sprintf( '<img src="%s" alt="%s" />', $image, $alt );

        if( $link || self::$parent_args['lightbox'] == 'yes' ) {
            $output = sprintf( '<a %s>%s</a>', HooCore_Plugin::attributes( 'image-carousel-shortcode-slide-link' ), $output );
        }

        $html = sprintf( '<div class="item"><div %s>%s</div></div>', HooCore_Plugin::attributes( 'image' ), $output );
        
        return $html;

    }
    
    function slide_link_attr() {

        $attr = array();

        $attr['href'] = self::$child_args['link'];
        
        $attr['target'] = self::$child_args['linktarget'];

        return $attr;

    }    

}

new Hoo_ImageCarousel();