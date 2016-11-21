<?php
/**
 * The search results template file.
 *
 * @since singlepage 1.3.9
 */

get_header(); ?>

<div id="main-content">
  <div class="page-main " role="main">
    <div class="container">
      <div class="breadcrumb-box">
        <?php singlepage_breadcrumb_trail(array("before"=>"","show_browse"=>false));?>
      </div>
      <div class="row">
        <div class="post-entry text-left right col-md-9">
          <div class="entry-main">
            <?php if (have_posts()) :?>
            <div class="pageing">
              <?php while ( have_posts() ) : the_post(); 
					    get_template_part("content","article");
					?>
              <?php endwhile;?>
            </div>
            <div class="pagination">
              <?php singlepage_native_pagenavi("echo",$wp_query);?>
            </div>
            <?php else:?>
            <div class="blog-list-wrap">
              <?php _e('No results found','singlepage');?>
              <?php get_search_form(); ?>
            </div>
            <?php endif;?>
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
