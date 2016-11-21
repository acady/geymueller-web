<?php
/**
 * The blog list template
 *
 * @since singlepage 1.3.6
 */


	if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' ) ) :
	    get_header();
        get_template_part("content","blog-list");
	    get_footer();
		else:
		get_template_part( 'template-home' );
     endif;
  


 