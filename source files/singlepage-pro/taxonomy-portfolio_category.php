<?php
/**
 * portfolio.
 *
 * @since singlepage 2.2.2
 */

get_header('page'); ?>
<div class="breadcrumb-box">
             <div class="container">
            <?php singlepage_breadcrumb_trail(array("before"=>"","show_browse"=>false));?>
            </div>
        </div>
<div class="portfolio-list">
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<section class="portfolio-main text-center" role="main">
							
                            <?php if (have_posts()) :?>
                            <div class="portfolio-list-wrap row">
                    <?php 
					global $dataID;
					$dataID = 0;
					while ( have_posts() ) : the_post(); 
					
					    $dataID++ ;
					    get_template_part("content","portfolio");
					?>
                   <?php endwhile;?>
                   </div>
                   <?php endif;?>
                  
                            		<div class="list-pagition text-center">
							<?php singlepage_native_pagenavi("echo",$wp_query);?>
							</div>
						</section>
					</div>
                    <div class="col-md-3">
						<aside class="portfolio-side left text-left">
							<div class="widget-area">
						<?php get_sidebar( 'portfolio' ); ?>
							</div>
						</aside>
					</div>
				</div>
			</div>	
		</div>
<?php get_footer(); ?>