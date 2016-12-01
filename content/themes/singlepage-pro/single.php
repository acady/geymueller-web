<?php
/**
 * The Template for displaying single post.
 *
 * @since singlepage 2.6.0
 */

		get_header();

?>

<div id="main-content">
<div class="container">
<div class="breadcrumb-box">
 <?php singlepage_breadcrumb_trail(array("before"=>"","show_browse"=>false));?>
</div>
<?php if (have_posts()) :
   while ( have_posts() ) : the_post();
       
?>
 <div class="row">
        <div class="blog-detail right-aside right col-md-9">
                        <section class="blog-main text-center" role="main">
                            <article class="post-entry text-left">
                                <div class="entry-main">
                                 
                                 <h1 class="entry-title"><?php the_title();?></h1>
                                    <div class="blog-header">
                  <div class="entry-author"><i class="fa fa-user"></i><?php echo get_the_author_link();?></div> 
                  
                  <div class="entry-category"><i class="fa fa-file-o"></i><?php the_category(', '); ?></div>
                  
                 <div class="entry-comments"><i class="fa fa-comment"></i><?php  comments_popup_link( __('No comments yet','singlepage'), __('1 comment','singlepage'), __('% comments','singlepage'), 'comments-link', __('No comment','singlepage'));?></div>
                 <?php edit_post_link( __('Edit','singlepage'), '<div class="entry-edit"><i class="fa fa-pencil"></i>', '</div>', get_the_ID() ); ?> 
                    <div class="clear"></div>
                </div>
                                    <div class="entry-content">
                                       <?php the_content();?>	
                                       <?php  wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'singlepage' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );?>
                                    </div>
                                </div>
                            </article>
                            <div class="comments-area text-left">
                             <?php
							 if ( comments_open() || get_comments_number() ) :
									echo '<div class="comment-wrapper">';
									comments_template(); 
									echo '</div>';
									endif;
                                  ?>    
                            </div>
                        </section>
                
        </div>
		<?php endwhile;?>
<?php endif;?>

 <side class="left col-md-3">
    <?php get_sidebar("blog");?>
    </side>
    </div>
    
 </div>
             </div><!--END main-content-->
  
<?php get_footer(); ?>