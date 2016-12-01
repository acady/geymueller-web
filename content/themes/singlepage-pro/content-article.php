<?php
   $hide_post_meta = of_get_option('hide_post_meta','no');
?>
   <article id="post-<?php the_ID();?>">
                <div class="post">
            		<a href="<?php the_permalink();?>"><h2 class="title"><?php the_title();?></h2></a>
                    <?php if( $hide_post_meta == 'no' ){?>
                    <div class="meta">
                        <ul>
                        	<li class="admin"><i class="fa fa-user"></i><?php echo get_the_author_link();?></li>
                            <li class="date"><i class="fa fa-calendar-o"></i><?php echo get_the_date("M d, Y");?></li>
                            <li class="category"><i class="fa fa-file-o"></i><?php the_category(', '); ?></li>
                            <li class="tags"><i class="fa fa-tags"></i><?php the_tags('<i class="fa fa-tags"></i>'); ?></li>
                            <li class="comments"><i class="fa fa-comment"></i><?php  comments_popup_link( __('No comments yet','singlepage'), __('1 comment','singlepage'), __('% comments','singlepage'), 'comments-link', __('No comment','singlepage'));?></li>
                            <li> <?php edit_post_link( __('Edit','singlepage'), '<div class="entry-edit"><i class="fa fa-pencil"></i>', '</div>', get_the_ID() ); ?> </li>
                        </ul>
                        <div class="clear"></div>
                    </div><!--end meta-->
                    <?php }?>
                    <span class="main-border"></span>
                    <?php
					if(has_post_thumbnail()) { the_post_thumbnail("blog"); } 
					?>
                    <?php the_excerpt();?>
                    <a class="read-more" href="<?php the_permalink();?>"><?php _e('Read More','singlepage');?> &rarr;</a>
  				</div><!--END post-->
                </article>