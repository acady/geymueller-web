<?php
/**
 * The blog list template
 *
 * @since singlepage 2.4.3
 */

/* $enable_home_page = of_get_option('enable_home_page',1);*/
  
if(   get_option( 'show_on_front' ) == 'page' && $wp_query->get_queried_object_id() != get_option( 'page_for_posts' ) ){
	//get_header("featured");
	get_template_part( 'template-home' );
	//get_footer();
	}
	else{
	 get_header();
      get_template_part("content","blog-list");
	 get_footer();
		}
  


 