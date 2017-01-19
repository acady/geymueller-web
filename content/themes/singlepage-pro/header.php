<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php wp_head(); ?>
<base href="/">
</head>
<body  id="page-template" <?php body_class(); ?> >

<?php
 $header_image       = get_header_image();
 if (isset($header_image) && ! empty( $header_image )) :
?>
<div class="header-image"><img src="<?php echo esc_url($header_image); ?>" alt="" /></div>
<?php endif;?>
<header class="navbar navbar-onex">
 <div class="container">
 
<div class="nav navbar-header">
		<div class="logo-container text-left">
                      
					 <?php if ( of_get_option('logo')!="") { ?>
        <a href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo esc_url(of_get_option('logo')); ?>" class="site-logo" alt="<?php bloginfo('name'); ?>" />
        </a>
        <?php } else{?>
					<div class="name-box">
						<a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1></a><br />
                         <?php if ( 'blank' != get_header_textcolor() && '' != get_header_textcolor() ){?>
						<span class="site-tagline"><?php  bloginfo('description');?></span>
                        <?php }?>
					</div>
                 <?php }?>
                    </div>
               
		 <div class="site-nav main-menu" id="navbar-collapse" role="navigation">
      
          <?php if(class_exists( 'woocommerce' ) && of_get_option('woocommerce_cart_enable') == "on"){ ?>
       
         <div class="singlepage-nav-right-container">
                    <ul>
                    	
                        <li class="singlepage-cart-list">
                        	<?php get_template_part( 'woocommerce/content', 'cart-list-btn' ); ?>
                            <div class="cart-list-contents-container">
                        	<?php get_template_part( 'woocommerce/content', 'cart-list' ); ?>
                            </div>
                        </li>
                    </ul>
                </div>
                 <?php } ?>
	 <nav>
			<?php wp_nav_menu(array('theme_location'=>'primary','depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s<li class="nav_focus">focus</li><li class="nav_default cur">default</li></ul>'));?>
   </nav>
		</div>
	</div>
    </div>
    </header>