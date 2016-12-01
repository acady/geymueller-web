<?php
class Hoo_Post {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {
		add_shortcode('hoo_post', array( $this, 'render' ) );

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
				'field'   => 'post_content',
				'default' => '',
				'before'  => '',
				'after'   => '',
				'post_id' => '',
			), $args
		);

		extract( $defaults );

		self::$args = $defaults;
		
	if ( !$post_id ) $post_id = get_the_ID();
		// Check post ID
		if ( !is_numeric( $post_id ) || $post_id < 1 ) return sprintf( '<p class="hoo-error">Post: %s</p>', __( 'post ID is incorrect', 'singlepage' ) );
		// Get the post
		$post = get_post( $post_id );
		// Set default value if meta is empty
		$post = ( empty( $post ) || empty( $post->$field ) ) ? $default : $post->$field;
		// Apply cutom filter

		// Return result
		return ( $post ) ? $before . $post . $after : '';

	}


}

new Hoo_Post();