<?php
/**
* The page template file.
*
*/
   get_header(); 

?>
<div id="main-content">
  <div class="page-main " role="main">
    <div class="container">
      <div id="page-<?php the_ID(); ?>" <?php post_class("clear"); ?>>
        <div class="post-entry text-left right col-md-9">
          <?php 
							
							if ( have_posts() ) :
							 while ( have_posts() ) : the_post(); 
							   
							?>
          <div class="pageing">
            <?php get_template_part("content","article");?>
          </div>
          <?php endwhile; endif;?>
          <div class="pagination">
            <?php singlepage_native_pagenavi("echo",$wp_query);?>
          </div>
          <div class="clear"></div>
        </div>
      </div>
      <side class="left col-md-3">
        <?php get_sidebar("blog");?>
      </side>
    </div>
  </div>
</div>
</div>
<?php get_footer(); ?>
