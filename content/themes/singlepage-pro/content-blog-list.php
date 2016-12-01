<div id="main-content">
  <div class="page-main " role="main">
    <div class="container">
    <div class="breadcrumb-box">
    <?php singlepage_breadcrumb_trail(array("before"=>"","show_browse"=>false));?>
  </div>
      <div class="row">
        <div class="post-entry text-left right col-md-9">
          <div class="entry-main">
            <?php 
							
							if ( have_posts() ) :
							?>
            <div class="pageing">
              <?php while ( have_posts() ) : the_post(); 
					    get_template_part("content","article");
					 endwhile;
					 
 ?>
            </div>
            <?php endif;?>
          </div>
            <div class="pagination">
    <?php singlepage_native_pagenavi("echo",$wp_query);?>
  </div>
        </div>  
    <side class="left col-md-3">
    <?php get_sidebar("blog");?>
    </side>
    
      </div>
    </div>
  </div>
  
  <div class="clear"></div>
</div>