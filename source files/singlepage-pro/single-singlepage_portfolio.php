<?php
/**
* The page template file.
*
*/
   get_header(); 

?>
<div id="page-<?php the_ID(); ?>" <?php post_class("clear"); ?>>
<?php if (have_posts()) :?>
<?php	while ( have_posts() ) : the_post();?>
<section id="container">
    <div class="container">
        <div class="row">
<div class="breadcrumb-box">
<?php singlepage_breadcrumb_trail(array("before"=>"","show_browse"=>false));?>
        </div>
        </div>
        <article class="portfolio-single">
         <div class="row">
            <div class="col-md-6">
               <div class="portfolio-img-slider">
								<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
									<!-- Indicators -->
                            <?php 
							 $portfolio_meta = array();
							 $portfolio_meta      =  get_post_meta( get_the_ID());
							
							 if( isset($portfolio_meta['portfolio_gallery'][0])  )
						      $portfolio_gallery = $portfolio_meta['portfolio_gallery'][0];

						     if( isset($portfolio_gallery)  && $portfolio_gallery != NULL){
	
							 $i          = 0;
							 $indicators = "";
							 $inner      = "";
		
							 
							 $attachment_id_arr = explode(",",$portfolio_gallery);
							 if($attachment_id_arr && is_array($attachment_id_arr)){
							 foreach($attachment_id_arr as $attachment_id){
							 $active = "";
							 if($i == 0) $active = "active";
							  $image_attributes = wp_get_attachment_image_src( $attachment_id, "portfolio" );
							  
							   $indicators .= '<li data-target="#carousel-example-generic" data-slide-to="'.$i.'" class="'.$active.'"></li>';
							   $inner      .= '<div class="item '.$active.'"><img src="'.$image_attributes[0].'" width="'.$image_attributes[1].'" height="'.$image_attributes[2].'" alt=""/></div>';
							   
							    $i++;
							   }
							   }

				
							 }else{
							 $feat_image = wp_get_attachment_image( get_post_thumbnail_id(get_the_ID()), 'portfolio');
				            if($feat_image ){ 
				              echo $feat_image;
				            }
							 }
						 ?> 
                                    
									<ol class="carousel-indicators">
									<?php echo $indicators;?>	
									</ol>
									<!-- Wrapper for slides -->
									<div class="carousel-inner">
                                    <?php echo $inner;?>										
									</div>
								</div>
							</div>
            </div>
            
            <div class="col-md-6">

                <h2><?php the_title();?></h2>
              <div class="portfolio-content">
               <?php the_content();?>
              </div>
                <hr>
                 <?php
				 $project_date = isset($portfolio_meta['project_date'][0])?date("d M Y",strtotime($portfolio_meta['project_date'][0])):"";
				 $client       = isset($portfolio_meta['client'][0])?$portfolio_meta['client'][0]:"";
				 $project_site = isset($portfolio_meta['project_site'][0])?$portfolio_meta['project_site'][0]:"";
				 $site_link    = isset($portfolio_meta['site_link'][0])?$portfolio_meta['site_link'][0]:"";
				 ?>
                <ul class="meta">
                <?php if( $project_date ){?>
                    <li><strong><?php _e('Date','singlepage');?>: </strong> <?php echo $project_date;?></li>
                <?php }?>
                <?php if( $project_date ){?>
                    <li><strong><?php _e('Client','singlepage');?>: </strong> <?php echo esc_attr($client);?></li>
                    <?php }?>
                   <?php if( $project_site ){?>
                    <li><strong><?php _e('URL Project','singlepage');?>:</strong> <a target="_blank" rel="nofollow" href="<?php echo esc_url($site_link);?>"><?php echo esc_attr($project_site);?></a></li>
                     <?php }?>
                </ul>

            </div>
            </div>
        </article>
 <?php if(isset($portfolio_meta["show_related_portfolios"]) && $portfolio_meta["show_related_portfolios"] == "on"){?>
      
        <div class="title-divider">
            <div class="divider-arrow"></div>                                  
            <h3><?php _e('Realted Work','singlepage');?></h3>       
        </div>
        <div class="container">
        <div class="row portfolio-list-wrap">
        
<?php echo singlepage_get_related_portfolios($post->ID,4)?>
          
        </div>
        </div>
        <?php }?>
    
    </div>    
</section>
<?php endwhile;?>
<?php endif;?>
</div>
<?php get_footer(); ?>