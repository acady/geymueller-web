<div id="sidebar-widgets">
           <?php
 if( is_active_sidebar( 'displayed_everywhere' ) ) {
	 dynamic_sidebar('displayed_everywhere');
	 }
	 if ( is_active_sidebar( 'blog' ) ){
	 dynamic_sidebar( 'blog' );
	 }
	 elseif( is_active_sidebar( 'default_sidebar' ) ) {
	 dynamic_sidebar('default_sidebar');
	 }
	 ?>
          
        </div><!--END sidebar-widgets-->

