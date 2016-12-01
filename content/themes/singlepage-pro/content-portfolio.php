<?php
   global $dataID;
?>

<article  data-id="id-<?php echo $dataID;?>"  class="entry-box text-left portfolio-item col-md-6">
                          
  <span>
    <?php 
						    
							if ( has_post_thumbnail()) {
								the_post_thumbnail("portfolio");
								}
								
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
							$featured_image = $image[0];
							
								?>
                            
                            <div class="pd">
                                <a href="<?php echo $featured_image;?>" class="p-view" data-rel="prettyPhoto"></a>
                                <a href="<?php the_permalink();?>" class="p-link"></a>
                            </div>
                        </span>
                        <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                        <p><?php the_excerpt();?></p>
                        <a href="<?php the_permalink();?>" class="read-more"><?php _e("Read More","singlepage");?> ...</a>

							</article>