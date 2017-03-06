/* ------------------------------------------------------------------------ */
/* one page home														*/
/* ------------------------------------------------------------------------ */

(function($) {
		if( $("body#featured-template").length && 
			  (
			   (singlepage_params.section_height_mode == '1' && singlepage_params.is_mobile == '0') ||
				(singlepage_params.section_height_mode_mobile == '1' && singlepage_params.is_mobile == '1' )
				) 
			  
			  ){
	var header_image_height = 0;
	if( $('.header-image').length )
	header_image_height = $('.header-image').height();
	
	
    var e = function() {
        var e = 0,
        t = null,
        n = null,
        r = 0,
        i = 0,
        s = 0,
        o = 0,
        u = $("#sub_nav_1 li"),
		l = u.length,
        a = $("html,body"),
        f = $(window),
		mousewheelevt=(/Firefox/i.test(navigator.userAgent))? "DOMMouseScroll" : "mousewheel";
        f.resize(function(e) {
            s = $(window).height();
        }).resize(),
        f.scroll(function(t) {
            r = $(this).scrollTop()+1,
            r < .3 * s ? e = 0 : r >= s && r < 1.3 * s ? e = 1 : r >= 2 * s && r < 2.3 * s ? e = 2 : r >= 3 * s && r < 3.3 * s ? e = 3 : r >= 4 * s && r < 4.3 * s ? e = 4 : r >= 5 * s && r < 5.3 * s ? e = 5 : r >= 6 * s && r < 6.3 * s ? e = 6 : r >= 7 * s && r < 7.3 * s ? e = 7 : r >= 8 * s && r < 8.3* s ? e = 8 : r >= 9 * s && r < 9.3 * s ? e = 9 : r >= 10 * s && r < 10.3 * s && (e = 11),
            u.removeClass("cur").eq(e).addClass("cur")
        }),
        a.on(mousewheelevt,
        function(n) {

           // o = window.event.detail ? -(window.event.detail || 0) / 3 : window.event.wheelDelta / 120;
			
			if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
            if (n.originalEvent.detail > 0) {
                //scroll down
                o = -1;
            } else {
                //scroll up
                o = 1;
            }
        } else {
            if (n.originalEvent.wheelDelta < 0) {
                //scroll down
                o = -1;
            } else {
                //scroll up
                o = 1;
            }
        }
		
            clearTimeout(t),
            t = setTimeout(function() {
                o > 0 && e > 0 ? e--:o < 0 && e < l && e++,
                a.animate({
                    scrollTop: s * (e>=l?(e-1):e)+header_image_height
                },
                Number(singlepage_params.scrolldelay), "easeInOutQuart");
				//if(e>=l){ $("body#featured-template #footer").css({"position":"fixed","bottom":"0"}); }else{$("body#featured-template #footer").css({"position":"static","bottom":"auto"});}
            },
            300),
            n.preventDefault();
			
        }),
        u.on("click",
        function(t) {
            i = $(this).index(),
            a.animate({
                scrollTop: s * i+header_image_height
            },
            Number(singlepage_params.scrolldelay), "easeInOutQuart",
            function() {
                e = i
            });
			//$("body#featured-template #footer").css({"position":"static","bottom":"auto"});
        });
		
		
    },
    t = function() {
        var e = $("nav > ul");
      if( e.length ){
		e.find(" > li.current-menu-item, > li.current-menu-parent").addClass("cur");
        var n = $("nav > ul > li.cur").not(".nav_default");
		if( !n.length){
			var n = $("nav > ul > li.nav_default");
			$("nav > ul > li.nav_focus").hide();
			}
		var t = $("nav > ul > li").not(".nav_focus"),
        r = e.find(".nav_focus"),
        i = n.outerWidth(),
        s = n.position().left + 6,
        o = n.index();
        r.stop(!0, !1).animate({
            left: s,
            width: i
        },
        300),
        t.eq(o).addClass("cur").end().on("mouseenter",
        function(e) {
			jQuery("nav > ul > li.nav_focus").show();
            var t = $(this),
            n = t.position().left + 6,
            i = t.outerWidth();
            t.addClass("cur").siblings().removeClass("cur"),
            r.stop(!0, !1).animate({
                left: n,
                width: i
            },
            300)
        }).siblings().removeClass("cur"),
        e.on("mouseleave",
        function(e) {
			if(i===0){
				$("nav > ul > li.nav_focus").hide();
				}
            r.stop(!0, !1).animate({
                left: s,
                width: i
            },
            300),
            t.eq(o).addClass("cur").siblings().removeClass("cur");
			
        });
		}
    };
    t(),
    e()
	}
})(jQuery);


function spClick(o){ 
	var o = document.getElementById(o); 
	if( document.all && typeof( document.all ) == "object" ) //IE 
	{ 
	o.fireEvent("onclick"); 
	} 
	else 
	{ 
	var e = document.createEvent('MouseEvent'); 
	e.initEvent('click',false,false); 
	o.dispatchEvent(e); 
	} 
} 



jQuery(document).ready(function($) {
												
if( $('#wrapper #main').length && $('#wrapper #side').length  ){
	
	if( $('#wrapper #main').outerHeight() > $('#wrapper #side').height()  ){
		$('#wrapper #side').height($('#wrapper #main').outerHeight());
	}
	
 }


$(function() {
	$('#featured-template #sub_nav_2 li a[href^="#"],#sub_nav_1 li a[href^="#"],.site-nav ul li a[href^="#"]').parent('li').bind('click', function(event) {
		var $anchor = $(this).find('a');
		if( $($anchor.attr('href')).length ){
		$('html, body').stop().animate({
			scrollTop: $($anchor.attr('href')).offset().top
		}, Number(singlepage_params.scrolldelay), 'easeInOutExpo',function () {
            //window.location.hash = target;
            $(document).on("scroll", onScroll);
        }
		);
		event.preventDefault();
		}
		
	});

});


$(function() {
	$('section a[href^="#"]').bind('click', function(event) {
													 
		var $anchor = $(this);
		
		if( $( $anchor.attr('href')).length ){
	
		$('html, body').stop().animate({
			scrollTop: $($anchor.attr('href')).offset().top
		}, Number(singlepage_params.scrolldelay), 'easeInOutExpo',function () {
            $(document).on("scroll", onScroll);
        }
		);
		event.preventDefault();
		}
		
	});

});


$(document).on("scroll", onScroll);

function onScroll(event){
    var scrollPos = $(document).scrollTop() + 1;

	  
    $('#featured-template #sub_nav_2 li a[href^="#"]').each(function () {
																	  
        var currLink = $(this);
		var currLi   = $(this).parent('li');
		
        var refElement = $(currLink.attr("href"));
		
        if ( refElement.length && refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('#featured-template #sub_nav_2 li').removeClass("cur");
            currLi.addClass("cur");
        }
        else{
            currLi.removeClass("cur");
        }
    });
	
	 $('.site-nav ul li a[href^="#"]').each(function () {
													  
        var currLink = $(this);
		var currLi   = $(this).parent('li');
		
        var refElement = $(currLink.attr("href"));
        if (refElement.length && refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('.site-nav ul li').removeClass("cur");
            currLi.addClass("cur");
        }
        else{
            currLi.removeClass("cur");
        }
    });
	 
}

// section full screen

if(
 (singlepage_params.section_height_mode == '2' && singlepage_params.is_mobile == '0') ||
				(singlepage_params.section_height_mode_mobile == '2' && singlepage_params.is_mobile == '1' )
				){

//if(singlepage_params.section_height_mode == '2'){
$("#featured-template section.section").each(function(){
											  
  $(this).css({'min-height':$(window).height()});						  
											  
  });
}else{

$("#featured-template section.section").each(function(){
			$(this).css({'height':$(window).height()});
			});
$( window ).resize(function() {
	$("#featured-template section.section").each(function(){
			$(this).css({'height':$(window).height()});
			});						
   });
}

  //
  
jQuery(window).resize(function($) {
	var windowWidth = jQuery(window).outerWidth(); 
	
	 if( windowWidth > 919 ){
		 jQuery(".site-nav").show();
	 }
	 else{
		jQuery(".site-nav").hide();
		 }
			 
  });
/* ------------------------------------------------------------------------ */
/* Singlepage slider												*/
/* ------------------------------------------------------------------------ */
if( $('.singlepage_slider_shortcode').length ){
	var offset    = $('.singlepage_slider_shortcode').offset();
	var windowWidth   = $(window).width();
	var silderHeight  = $(window).height();
	if( $('.singlepage_slider').data("height")>0 )
	silderHeight = $('.singlepage_slider').data("height");
	
	$('.full_width_singlepage_slider_wrapper > section').css({'position':'absolute','padding':0,'max-height':'none','overflow':'visible','width':windowWidth,'height':silderHeight,'left':(-offset.left)});
	
	$('.singlepage_slider_shortcode > section').css({'padding':0,'max-height':'none','height':silderHeight});
	$('.singlepage_slider_shortcode .singlepage-slider-fullwidth-forcer').css({'height':silderHeight});
	
	}
	jQuery(window).resize(function($) {
		if( jQuery('.singlepage_slider_shortcode').length ){
	var offset       = jQuery('.singlepage_slider_shortcode').offset();
	var windowWidth  = jQuery(window).width();
	var silderHeight = jQuery(window).height();
	jQuery('.full_width_singlepage_slider_wrapper > section').css({'position':'absolute','padding':0,'max-height':'none','overflow':'visible','width':windowWidth,'height':silderHeight,'left':(-offset.left)});
	jQuery('.singlepage_slider_shortcode > section').css({'padding':0,'max-height':'none','height':silderHeight});
	jQuery('.singlepage_slider_shortcode .singlepage-slider-fullwidth-forcer').css({'height':silderHeight});
	
	}						   
							   
 });


/* ------------------------------------------------------------------------ */
/* fixed header															*/
/* ------------------------------------------------------------------------ */
var adminbarHeight = 0;
	if( $("body.admin-bar").length){
		if( $(window).width() < 765) {
				adminbarHeight = 46;
				
			} else {
				adminbarHeight = 32;
			}
	  }
	  
$('#featured-template header').css({top:adminbarHeight});
 var headerHeight = $('header.navbar').height();
$('#featured-template header').affix({offset: {top: headerHeight-adminbarHeight}}); 
$('.navbar').click(function(){	
								 
//	$(".main-menu").toggle();		 
   });
$(".site-nav-toggle").click(function(){
				$(".site-nav").toggle();
			});
/* ------------------------------------------------------------------------ */
/* Preserving aspect ratio for embedded iframes														*/
/* ------------------------------------------------------------------------ */
$('.entry-content embed,.entry-content iframe').each(function(){
										
		var width  = $(this).attr('width');	
		var height = $(this).attr('height');
		if($.isNumeric(width) && $.isNumeric(height)){
			if(width > $(this).width()){
				var new_height = (height/width)*$(this).width();
				$(this).css({'height':new_height});
				}
			
			}				
    });


 //WOW
 wow = new WOW(
      {
        animateClass: 'animated',
        offset:       100
      }
    );
    wow.init();
	
	
	 //prettyPhoto
    $('a[data-rel]').each(function() {
        $(this).attr('rel', $(this).data('rel'));
    });
    $("a[rel^='prettyPhoto']").prettyPhoto();
    $("[rel^='tooltip']").tooltip('hide');
    $("[rel^='popover']").popover('hide');
    // portfolio

  $('.portfolio-list-wrap .col-md-6:even').addClass('no-marin-left');
  $('.portfolio-list-wrap > li, .portfolio-list-wrap  article > span').hoverdir();

    prettyPrint();
	

//fact
$('.fact').waypoint(function(down) {
		$('.fact').each(function () {
			var $this = $(this);
			$({ Counter: 0 }).animate({ Counter: $(this).data('fact') }, {
				duration: 1000,
				easing: 'swing',
				step: function () {
				    $this.text(Math.ceil(this.Counter));
				}
			});
		});
	},	
	{
	  offset: '90%',
	  triggerOnce: true
	});

// Testimonials
	function onAfter( curr, next, opts, fwd ) {
	  var $ht = $( this ).height();

	  //set the container's height to that of the current slide
	  $( this ).parent().css( 'height' , $ht );
	}

	if( jQuery().cycle ) {
		var reviews_cycle_args = {
			fx: 'fade',
			after: onAfter,
			delay: 0
		};

	    $( '.reviews' ).cycle( reviews_cycle_args );
	}
	//carousel
	
	$(".ot-carousel").each(function(){
	 var items = $(this).parents(".singlepage-image-carousel").data("items");
	 if( typeof items === 'undefined' || items === '' || items === '0' )
	 {
		 items = 4;
		 }
	 $(this).owlCarousel({
 
      autoPlay: 3000, //Set AutoPlay to 3 seconds
      items : items,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3],
	  navigation:true,
	  pagination:false,
	  navigationText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"]
 
  });
	 });
	
	
		// animate progress bar
	jQuery.fn.hoo_draw_progress = function() {
		var progressbar = jQuery( this );
		if ( jQuery( 'html' ).hasClass( 'lt-ie9' ) ) {
			progressbar.css( 'visibility', 'visible' );
			progressbar.each( function() {
				var percentage = progressbar.find( '.progress' ).attr("aria-valuenow");
				progressbar.find( '.progress' ).css( 'width', '0%' );
				progressbar.find( '.progress' ).animate( {
					width: percentage+'%'
				}, 'slow' );
			} );
		} else {
			progressbar.find( '.progress' ).css( "width", function() {
				return jQuery( this ).attr( "aria-valuenow" ) + "%";
			});
		}
	};
	
	
	// Progressbar
	jQuery( '.hoo-progressbar' ).not('.hoo-modal .hoo-progressbar').waypoint( function() {
		jQuery(this).hoo_draw_progress();
	}, {
		triggerOnce: true,
		offset: 'bottom-in-view'
	});
			

			
	//
	/* ------------------------------------------------------------------------ */
/*  SNS TIP															*/
/* ------------------------------------------------------------------------ */
	 
 $('.social-icons a').tooltip('hide');
 
 /*----------------------------------------------------*/
/* MOBILE DETECT FUNCTION
/*----------------------------------------------------*/

	var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };	  
	

			
/* ------------------------------------------------------------------------ */
/* Preserving aspect ratio for embedded iframes														*/
/* ------------------------------------------------------------------------ */
$('.entry-content embed,.entry-content iframe').each(function(){
										
		var width  = $(this).attr('width');	
		var height = $(this).attr('height');
		if($.isNumeric(width) && $.isNumeric(height)){
			if(width > $(this).width()){
				var new_height = (height/width)*$(this).width();
				$(this).css({'height':new_height});
				}
			
			}				
    });
/* ------------------------------------------------------------------------ */
/* 													*/
/* ------------------------------------------------------------------------ */		
$('.sub_nav ul li a[href^="#"]').click(function(e){
							e.preventDefault();		 
						})


		
/*----------------------------------------------------*/
// contact form
/*----------------------------------------------------*/ 	
	jQuery("form.contact-form .form-submit").click(function(e){
	

	var obj = jQuery(this).parents(".contact-form");
	
	var sendto  = obj.find("input#receiver_email").val();
	obj.find('input,textarea').removeClass('error');
	var values = new Array();
    var error  = false;
	var emailReg  = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	var yourEmail = '';
  
	obj.find("fieldset").find('input, select, textarea').each(
    function(index){
		var field = jQuery(this);
		values[index] = new Array(); 
		var name = field.attr('placeholder');
		if( name =='' ){
			name = 'Field '+index;
			}
        
		values[index]['name']        = name;
		values[index]['value']       = field.val();
		//values[index]['placeholder'] = field.attr('placeholder');
		if( field.attr('required')=='required' && field.val() == ''){
			error = true;
			field.addClass('error');
			}
		 if( field.attr('type') == 'email' && emailReg.test( field.val() ) === false){
			error = true;
			field.addClass('error');
			}
		if( field.attr('type') == 'email' && emailReg.test( field.val() ) === true){
			yourEmail =  field.val();
			}
			
			
    });
   if( error  === false ){
	obj.find(".form-actions .form-submit").css("backgroundImage", "url("+singlepage_params.themeurl+"/images/sending.gif)");
	 jQuery.ajax({
				 type:"POST",
				 dataType:"json",
				 url:singlepage_params.ajaxurl,
				 data: {
                'values': jQuery.param(values)+'&sendto='+sendto+'&your_email='+yourEmail,
				'action':'singlepage_contact',
				'sendto':sendto
            },
				 success:function(data){
					
		           obj.find(".form-actions .form-submit").css("backgroundImage", "url("+singlepage_params.themeurl+"/images/complete.png)");
				   obj[0].reset(); 
		           return false;
				   },error:function(){
					    obj.find(".form-actions .form-submit").css("backgroundImage", "url("+singlepage_params.themeurl+"/images/failed.png)");
					   return false;
					   }
					   });
	// 
	 }
	
	 });


	
/*----------------------------------------------------*/
// video background
/*----------------------------------------------------*/  

  if( typeof background_video !== 'undefined'  ){
  var	loop = false;
  if( background_video.loop == 'true' )
	  loop = true;
	  
   var autoplay = true;
  if( background_video.autoplay == '' || background_video.autoplay == '0' )
   autoplay = false;
	  
  $(background_video.container).prepend('<div class="video-background"></div>');
				$('.video-background').videobackground({
					videoSource: [[background_video.mp4_video_url, 'video/mp4'],
						[background_video.webm_video_url, 'video/webm'], 
						[background_video.ogv_video_url, 'video/ogg']], 
					controlPosition: background_video.container,
					poster: background_video.poster_url,
					loop:loop,
					autoplay:autoplay,
					volume: parseFloat(background_video.volume),
					resizeTo: 'container',
					loadedCallback: function() {
						$(this).videobackground('mute');
						if(background_video.display_buttons == '0')
						$(background_video.container).find('.ui-video-background').hide();
					}
				});
		}
		
 $(".play-video").on("click", function(){
        var video = $(this).parents('section.section').find('video')[0];
        video.play();
        $(".play-video").hide();
    });
	 


/* ------------------------------------------------------------------------ */
/* home page full screen google map													*/
/* ------------------------------------------------------------------------ */
 if( $('section.singlepage-google-map-section').length && typeof singlepage_google_map !== 'undefined' && typeof google !== 'undefined'){
  var geocoder;
  var map;
  function initialize() {
	geocoder = new google.maps.Geocoder();
	var scrollwheel,scaleControl;
	scrollwheel = singlepage_google_map.scrollwheel ==='true'?true:false;
	scaleControl = singlepage_google_map.scaleControl ==='true'?true:false;
	  
	var latlng = new google.maps.LatLng(-34.397, 150.644);
	var mapOptions = {
	  zoom: Number(singlepage_google_map.google_map_zoom),
	  center: latlng,
	  scrollwheel:scrollwheel,
	  scaleControl:scaleControl
	}
	map = new google.maps.Map(document.getElementById(singlepage_google_map.google_map_wrap), mapOptions);
	codeAddress();
  
  
  //directions
 if(singlepage_google_map.start != '' && singlepage_google_map.end != '') {
			
			var directionDisplay;
			var directionsService = new google.maps.DirectionsService();
		    directionsDisplay = new google.maps.DirectionsRenderer();
		    directionsDisplay.setMap( map );
    		directionsDisplay.setPanel(document.getElementById("directionsPanel"));

				var start = singlepage_google_map.start;
				var end =  singlepage_google_map.end;
				var request = {
					origin:start, 
					destination:end,
					travelMode: google.maps.DirectionsTravelMode.DRIVING
				};
				directionsService.route(request, function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) {
						directionsDisplay.setDirections(response);
					}
				});


	
		}
		
		//traffic
		if( singlepage_google_map.traffic == 'yes')
		{
	
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap( map );
			
		}
	
		//bike
		if(singlepage_google_map.bike == 'yes')
		{
				
			var bikeLayer = new google.maps.BicyclingLayer();
			bikeLayer.setMap(map);
			
		}
		
		
}

 function codeAddress() {
  var address = singlepage_google_map.google_map_address;
  
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location,
		  icon:singlepage_google_map.icon
      });

 if( singlepage_google_map.infowindow ){
	 var infowindow = new google.maps.InfoWindow({
      content: singlepage_google_map.infowindow
  });
 infowindow.open(map,marker);  
 google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });
 }
	   
    } else {
  
    }
  });
  

			
}

google.maps.event.addDomListener(window, 'load', initialize);


 }
 
 /* ------------------------------------------------------------------------ */
/* home page sidebar menu style 											*/
/* ------------------------------------------------------------------------ */
 
 if( $('#sub_nav').length){
	var adminbarHeight = 0;
	if( $("body.admin-bar").length){
		if( $(window).width() < 765) {
				adminbarHeight = 46;
				
			} else {
				adminbarHeight = 32;
			}
	  }
	  var headerHeight = $('header.navbar').height();
	  
	  var marginTop    = headerHeight+adminbarHeight+20;
	  if( $(window).width() > 768) {
		  marginTop    = marginTop + 30;
	  }
	  
	  
$('#sub_nav .sub_nav').css({'top':marginTop});

}

  $("#panel-cog").click(function(){
								 
  if($(".sub_nav_style2 .sub_nav").hasClass("hide-sidebar")){
    $(".sub_nav_style2 .sub_nav").removeClass("hide-sidebar");

  }
  else{
     $(".sub_nav_style2 .sub_nav").addClass("hide-sidebar");	
  
	}
  })
  
    // responsive menu
  if( $('header nav > ul').length )
    $('header nav,#navigation nav').meanmenu({meanScreenWidth:919});

  /* ------------------------------------------------------------------------ */
/*  smooth scrolling  btn       	  								  	    */
/* ------------------------------------------------------------------------ */

  $(document).on('click',"header a[href^='#'],a.scroll", function(e){
				var selectorHeight = $('header').height();   
				var scrollTop = $(window).scrollTop(); 
				e.preventDefault();
		 		var id = $(this).attr('href');
				if(typeof $(id).offset() !== 'undefined'){
				if( $("#featured-template").length ){
					var goTo = $(id).offset().top;
					}else{
				    var goTo = $(id).offset().top - selectorHeight;
				}
				$("html, body").animate({ scrollTop: goTo }, 1000,function () {

            $(document).on("scroll", onScroll);
        });
				}

 });
  
  // woocommerce
 $('.woocommerce-ordering .orderby-list li li').click(function() {
			if($(this).hasClass('select')){return false;}
			
            $('.woocommerce-ordering input.orderby-name').val($(this).data('value'));
			
			$('.woocommerce-ordering').submit();
        });
  
  $('.orderby-list-page-number li li').click(function() {
            if($(this).hasClass('select')){return false;}
			if($('.woocommerce-ordering input[name=woo-per-page-num]').length === 0){
				$('.woocommerce-ordering').append('<input type="hidden" name="woo-per-page-num" value="'+ $(this).data('value') + '" />');
			}else{
				$('.woocommerce-ordering input[name=woo-per-page-num]').val($(this).data('value'));
			}
			if($('.woocommerce-ordering input[name=paged]').length !== 0){
				$('.woocommerce-ordering input[name=paged]').val('1');
			}
			
			$('.woocommerce-ordering').submit();
        });
		
		$('.woocommerce-ordering-listorder a').click(function() {
            if($(this).hasClass('select') && $(this).find('i').length === 0){
				return false;
			}
			
			if($(this).hasClass('listorder-price')){
				if($(this).hasClass('up')){
					$('.woocommerce-ordering input.orderby-name').val('price-desc');
				}else{
					$('.woocommerce-ordering input.orderby-name').val('price');
				}
				
			}else if($(this).hasClass('listorder-popularity')){
				
				$('.woocommerce-ordering input.orderby-name').val('popularity');
				
			}else if($(this).hasClass('listorder-rate')){
				$('.woocommerce-ordering input.orderby-name').val('rating');
			}
			
			$('.woocommerce-ordering').submit();
			
        });
		
 $('#product-nav').flexslider({
					animation: "slide",
					controlNav: false,
					directionNav: false,
					animationLoop: false,
					slideshow: false,
					itemWidth: 106,
					itemMargin: 10,
					asNavFor: '#product-images'
				});
 $('#product-images').flexslider({
					animation: "slide",
					controlNav: false,
					directionNav: true,
					animationLoop: false,
					slideshow: false,
					prevText: '<i class="fa fa-angle-left"></i>',
					nextText: '<i class="fa fa-angle-right"></i>',
					
				});
 
 cartInit();
 function cartInit(){
		if(jQuery(window).width() > 700){
			$('.singlepage-cart-list').mouseenter(function() {
				$('.cart-list-contents-container').show();
			});
			$('.singlepage-cart-list').mouseleave(function() {
				$('.cart-list-contents-container').hide();
			});
		}
		
	}
	
/* ------------------------------------------------------------------------ */
/* home page youtube video 	  								  	    */
/* ------------------------------------------------------------------------ */ 
  if( jQuery('#home_youtube_video').length){
	  jQuery.mbYTPlayer.apiKey = "AIzaSyB_z8WrsKw2kIplh5kBc6xTawEDu91V5dQ";
	  var myPlayer;
	  myPlayer  = jQuery('#home_youtube_video').YTPlayer();
	}


 });


function progressBar(percent, $element) {
	var progressBarWidth = percent * $element.width() / 100;
	$element.find('div').animate({ width: progressBarWidth }, 500).html(percent + "%&nbsp;");
}



;(function ( $, window, document, undefined ) {

	"use strict";
	
	var $plugin_name = "singlepage_maps",
		$defaults 	 = {
			addresses: 	{},
			address_pin: true,
			animations: true,
			delay: 10, // delay between each address if over_query_limit is reached
			infobox_background_color: false,
			infobox_styling: 'default',
			infobox_text_color: false,
			map_style: 'default',
			map_type: 'roadmap',
			marker_icon: false,
			overlay_color: false,
			overlay_color_hsl: {}, // hue, saturation, lightness object
			pan_control: true,
			show_address: true,
			scale_control: true,
			scrollwheel: true,
			zoom: 9,
			zoom_control: true
		};

	// Plugin Constructor
	function Plugin( $element, $options ) {
		this.element 	= $element;
		this.settings 	= $.extend( {}, $defaults, $options );
		this._defaults 	= $defaults;
		this._name 		= $plugin_name;

		this.geocoder = new google.maps.Geocoder();
		this.next_address = 0;
		this.infowindow = new google.maps.InfoWindow();
		
		this.init();
	}

	// Avoid Plugin.prototype conflicts
	$.extend(Plugin.prototype, {
		init: function() {
			var $map_options = {
					zoom: this.settings.zoom,
					mapTypeId: this.settings.map_type,
					scrollwheel: this.settings.scrollwheel,
					scaleControl: this.settings.scale_control,
					panControl: this.settings.pan_control,
					zoomControl: this.settings.zoom_control
				},
				$latlng, $styles,
				$isDraggable = $(document).width() > 640 ? true : false;


			if( this.settings.scrollwheel ) {
				$map_options.draggable = $isDraggable;
			}

			if( ! this.settings.address_pin ) {
				this.settings.addresses = [ this.settings.addresses[0] ];
			}

			if( this.settings.addresses[0].coordinates ) {
				$latlng = new google.maps.LatLng( this.settings.addresses[0].latitude, this.settings.addresses[0].longitude );
				$map_options.center = $latlng;
			}

			this.map = new google.maps.Map( this.element, $map_options );

			if( this.settings.overlay_color && this.settings.map_style == 'custom' ) {
				$styles = [
					{
						stylers: [
							{ hue: this.settings.overlay_color },
							{ lightness: this.settings.overlay_color_hsl.lum * 2 - 100 },
							{ saturation: this.settings.overlay_color_hsl.sat * 2 - 100 }
						]
					},
					{
						featureType: 'road',
						elementType: 'geometry',
						stylers: [
							{ visibility: 'simplified' }
						]
					},
					{
						featureType: 'road',
						elementType: 'labels'
					}
				];

				this.map.setOptions({
					styles: $styles
				});
			}

			this.next_geocode_request();
		},
		/**
		 * Geocoding Addresses
		 * @param  object $search object with address
		 * @return void
		 */
		geocode_address: function( $search ) {
			var $plugin_object = this,
				$address_object;

			if( $search.coordinates === true ) {
				$address_object = { latLng: new google.maps.LatLng( $search.latitude, $search.longitude ) };
			} else {
				$address_object = { address: $search.address };
			}

			this.geocoder.geocode($address_object, function( $results, $status ) {
				var $latitude, $longitude, $location;

				if( $status == google.maps.GeocoderStatus.OK ) {
					$location = $results[0].geometry.location; // first location
					$latitude = $location.lat();
					$longitude = $location.lng();
					
					if( $search.coordinates === true && $search.infobox_content === '' ) {
						$search.geocoded_address = $results[0].formatted_address;
					}

					// If first address is not a coordinate, set a center through address
					if( $plugin_object.next_address == 1 && ! $search.coordinates ) {
						$plugin_object.map.setCenter( $results[0].geometry.location );
					}

					if( $plugin_object.settings.address_pin ) {
						$plugin_object.create_marker( $search, $latitude, $longitude );
					}
				} else {
					// if over query limit, go back and try again with a delayed call
					if( $status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT ) {
						$plugin_object.next_address--;
						$plugin_object.settings.delay++;
					}
				}

				$plugin_object.next_geocode_request();
			});
		},
		create_marker: function( $address, $latitude, $longitude ) {
			var $content_string,
				$marker_settings = {
					position: new google.maps.LatLng( $latitude, $longitude ),
					map: this.map
				},
				$marker;

			if( $address.infobox_content ) {
				$content_string = $address.infobox_content;
			} else {
				$content_string = $address.address;

				// Use google maps suggested address if coordinates were used
				if( $address.coordinates === true && $address.geocoded_address ) {
					$content_string = $address.geocoded_address;
				}
			}

			if( this.settings.animations ) {
				$marker_settings.animation = google.maps.Animation.DROP;
			}

			if( this.settings.map_style == 'custom' && this.settings.marker_icon == 'theme' ) {
				$marker_settings.icon = new google.maps.MarkerImage( $address.marker, null, null, null, new google.maps.Size( 37, 55 ) );
			} else if( this.settings.map_style == 'custom' && $address.marker ) {
				$marker_settings.icon = $address.marker;
			}

			$marker = new google.maps.Marker( $marker_settings );

			this.create_infowindow( $content_string, $marker );
		},
		create_infowindow: function( $content_string, $marker ) {
			var $info_window, $info_box_div, $info_box_options,
				$plugin_object = this;

			if( this.settings.infobox_styling == 'custom' && this.settings.map_style == 'custom' ) {
				$info_box_div = document.createElement('div');
				
				$info_box_options = {
					content: $info_box_div,
					disableAutoPan: false,
					maxWidth: 150,
					pixelOffset: new google.maps.Size( -125, 10 ),
					zIndex: null,
					boxStyle: { 
						background: 'none',
						opacity: 1,
						width: '250px'
					},
					closeBoxMargin: '2px 2px 2px 2px',
					closeBoxURL: '//www.google.com/intl/en_us/mapfiles/close.gif',
					infoBoxClearance: new google.maps.Size( 1, 1 )
				};

				$info_box_div.className = 'singlepage-info-box';
				$info_box_div.style.cssText = 'background-color:' + this.settings.infobox_background_color + ';color:' + this.settings.infobox_text_color  + ';';

				$info_box_div.innerHTML = $content_string;

				$info_window = new InfoBox( $info_box_options );
				$info_window.open( this.map, $marker );

				if( ! this.settings.show_address ) {
					$info_window.setVisible( false );
				}

				google.maps.event.addListener( $marker, 'click', function() {
					if( $info_window.getVisible() ) {
						$info_window.setVisible( false );
					} else {
						$info_window.setVisible( true );
					}
				});	
			} else {
				$info_window = new google.maps.InfoWindow({
					content: $content_string
				});
			
				if( this.settings.show_address ) {
					$info_window.show = true;
					$info_window.open( this.map, $marker );
				}		  

				google.maps.event.addListener( $marker, 'click', function() {
					if( $info_window.show ) {
						$info_window.close( $plugin_object.map, this );
						$info_window.show = false;
					} else {
						$info_window.open( $plugin_object.map, this );
						$info_window.show = true;
					}
				});
			}
		},
		/**
		 * Helps with avoiding OVER_QUERY_LIMIT google maps limit
		 * @return void
		 */
		next_geocode_request: function() {
			var $plugin_object = this;

			if ( this.next_address < this.settings.addresses.length ) {
				setTimeout( function() {
					$plugin_object.geocode_address( $plugin_object.settings.addresses[$plugin_object.next_address] );
					$plugin_object.next_address++;
				}, this.settings.delay );
			}
		}
	});

	$.fn[ $plugin_name ] = function ( $options ) {
		this.each(function() {
			if ( ! $.data( this, 'plugin_' + $plugin_name ) ) {
				$.data( this, 'plugin_' + $plugin_name, new Plugin( this, $options ) );
			}
		});

		return this;
	};

})( jQuery, window, document );




/*!
* responsive menu
*/
(function ($) {
	"use strict";
		$.fn.meanmenu = function (options) {
				var defaults = {
						meanMenuTarget: jQuery(this), // Target the current HTML markup you wish to replace
						meanMenuContainer: 'body', // Choose where meanmenu will be placed within the HTML
						meanMenuClose: "X", // single character you want to represent the close menu button
						meanMenuCloseSize: "18px", // set font size of close button
						meanMenuOpen: "<span /><span /><span />", // text/markup you want when menu is closed
						meanRevealPosition: "right", // left right or center positions
						meanRevealPositionDistance: "0", // Tweak the position of the menu
						meanRevealColour: "", // override CSS colours for the reveal background
						meanScreenWidth: "480", // set the screen width you want meanmenu to kick in at
						meanNavPush: "", // set a height here in px, em or % if you want to budge your layout now the navigation is missing.
						meanShowChildren: true, // true to show children in the menu, false to hide them
						meanExpandableChildren: true, // true to allow expand/collapse children
						meanExpand: "+", // single character you want to represent the expand for ULs
						meanContract: "-", // single character you want to represent the contract for ULs
						meanRemoveAttrs: false, // true to remove classes and IDs, false to keep them
						onePage: false, // set to true for one page sites
						meanDisplay: "block", // override display method for table cell based layouts e.g. table-cell
						removeElements: "" // set to hide page elements
				};
				options = $.extend(defaults, options);

				// get browser width
				var currentWidth = window.innerWidth || document.documentElement.clientWidth;

				return this.each(function () {
						var meanMenu = options.meanMenuTarget;
						var meanContainer = options.meanMenuContainer;
						var meanMenuClose = options.meanMenuClose;
						var meanMenuCloseSize = options.meanMenuCloseSize;
						var meanMenuOpen = options.meanMenuOpen;
						var meanRevealPosition = options.meanRevealPosition;
						var meanRevealPositionDistance = options.meanRevealPositionDistance;
						var meanRevealColour = options.meanRevealColour;
						var meanScreenWidth = options.meanScreenWidth;
						var meanNavPush = options.meanNavPush;
						var meanRevealClass = ".meanmenu-reveal";
						var meanShowChildren = options.meanShowChildren;
						var meanExpandableChildren = options.meanExpandableChildren;
						var meanExpand = options.meanExpand;
						var meanContract = options.meanContract;
						var meanRemoveAttrs = options.meanRemoveAttrs;
						var onePage = options.onePage;
						var meanDisplay = options.meanDisplay;
						var removeElements = options.removeElements;

						//detect known mobile/tablet usage
						var isMobile = false;
						if ( (navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i)) || (navigator.userAgent.match(/Android/i)) || (navigator.userAgent.match(/Blackberry/i)) || (navigator.userAgent.match(/Windows Phone/i)) ) {
								isMobile = true;
						}

						if ( (navigator.userAgent.match(/MSIE 8/i)) || (navigator.userAgent.match(/MSIE 7/i)) ) {
							// add scrollbar for IE7 & 8 to stop breaking resize function on small content sites
								jQuery('html').css("overflow-y" , "scroll");
						}

						var meanRevealPos = "";
						var meanCentered = function() {
							if (meanRevealPosition === "center") {
								var newWidth = window.innerWidth || document.documentElement.clientWidth;
								var meanCenter = ( (newWidth/2)-22 )+"px";
								meanRevealPos = "left:" + meanCenter + ";right:auto;";

								if (!isMobile) {
									jQuery('.meanmenu-reveal').css("left",meanCenter);
								} else {
									jQuery('.meanmenu-reveal').animate({
											left: meanCenter
									});
								}
							}
						};

						var menuOn = false;
						var meanMenuExist = false;


						if (meanRevealPosition === "right") {
								meanRevealPos = "right:" + meanRevealPositionDistance + ";left:auto;";
						}
						if (meanRevealPosition === "left") {
								meanRevealPos = "left:" + meanRevealPositionDistance + ";right:auto;";
						}
						// run center function
						meanCentered();

						// set all styles for mean-reveal
						var $navreveal = "";

						var meanInner = function() {
								// get last class name
								if (jQuery($navreveal).is(".meanmenu-reveal.meanclose")) {
										$navreveal.html(meanMenuClose);
								} else {
										$navreveal.html(meanMenuOpen);
								}
						};

						// re-instate original nav (and call this on window.width functions)
						var meanOriginal = function() {
							jQuery('.mean-bar,.mean-push').remove();
							jQuery(meanContainer).removeClass("mean-container");
							jQuery(meanMenu).css('display', meanDisplay);
							menuOn = false;
							meanMenuExist = false;
							jQuery(removeElements).removeClass('mean-remove');
						};

						// navigation reveal
						var showMeanMenu = function() {
								var meanStyles = "background:"+meanRevealColour+";color:"+meanRevealColour+";"+meanRevealPos;
								if (currentWidth <= meanScreenWidth) {
								jQuery(removeElements).addClass('mean-remove');
									meanMenuExist = true;
									// add class to body so we don't need to worry about media queries here, all CSS is wrapped in '.mean-container'
									jQuery(meanContainer).addClass("mean-container");
									jQuery('.mean-container').prepend('<div class="mean-bar"><a href="#nav" class="meanmenu-reveal" style="'+meanStyles+'">Show Navigation</a><nav class="mean-nav"></nav></div>');

									//push meanMenu navigation into .mean-nav
									var meanMenuContents = jQuery(meanMenu).html();
									jQuery('.mean-nav').html(meanMenuContents);

									// remove all classes from EVERYTHING inside meanmenu nav
									if(meanRemoveAttrs) {
										jQuery('nav.mean-nav ul, nav.mean-nav ul *').each(function() {
											// First check if this has mean-remove class
											if (jQuery(this).is('.mean-remove')) {
												jQuery(this).attr('class', 'mean-remove');
											} else {
												jQuery(this).removeAttr("class");
											}
											jQuery(this).removeAttr("id");
										});
									}

									// push in a holder div (this can be used if removal of nav is causing layout issues)
									jQuery(meanMenu).before('<div class="mean-push" />');
									jQuery('.mean-push').css("margin-top",meanNavPush);

									// hide current navigation and reveal mean nav link
									jQuery(meanMenu).hide();
									jQuery(".meanmenu-reveal").show();

									// turn 'X' on or off
									jQuery(meanRevealClass).html(meanMenuOpen);
									$navreveal = jQuery(meanRevealClass);

									//hide mean-nav ul
									jQuery('.mean-nav ul').hide();

									// hide sub nav
									if(meanShowChildren) {
											// allow expandable sub nav(s)
											if(meanExpandableChildren){
												jQuery('.mean-nav ul ul').each(function() {
														if(jQuery(this).children().length){
																jQuery(this,'li:first').parent().append('<a class="mean-expand" href="#" style="font-size: '+ meanMenuCloseSize +'">'+ meanExpand +'</a>');
														}
												});
												jQuery('.mean-expand').on("click",function(e){
														e.preventDefault();
															if (jQuery(this).hasClass("mean-clicked")) {
																	jQuery(this).text(meanExpand);
																jQuery(this).prev('ul').slideUp(300, function(){});
														} else {
																jQuery(this).text(meanContract);
																jQuery(this).prev('ul').slideDown(300, function(){});
														}
														jQuery(this).toggleClass("mean-clicked");
												});
											} else {
													jQuery('.mean-nav ul ul').show();
											}
									} else {
											jQuery('.mean-nav ul ul').hide();
									}

									// add last class to tidy up borders
									jQuery('.mean-nav ul li').last().addClass('mean-last');
									$navreveal.removeClass("meanclose");
									jQuery($navreveal).click(function(e){
										e.preventDefault();
								if( menuOn === false ) {
												$navreveal.css("text-align", "center");
												$navreveal.css("text-indent", "0");
												$navreveal.css("font-size", meanMenuCloseSize);
												jQuery('.mean-nav ul:first').slideDown();
												menuOn = true;
										} else {
											jQuery('.mean-nav ul:first').slideUp();
											menuOn = false;
										}
											$navreveal.toggleClass("meanclose");
											meanInner();
											jQuery(removeElements).addClass('mean-remove');
									});

									// for one page websites, reset all variables...
									if ( onePage ) {
										jQuery('.mean-nav ul > li > a:first-child').on( "click" , function () {
											jQuery('.mean-nav ul:first').slideUp();
											menuOn = false;
											jQuery($navreveal).toggleClass("meanclose").html(meanMenuOpen);
										});
									}
							} else {
								meanOriginal();
							}
						};

						if (!isMobile) {
								// reset menu on resize above meanScreenWidth
								jQuery(window).resize(function () {
										currentWidth = window.innerWidth || document.documentElement.clientWidth;
										if (currentWidth > meanScreenWidth) {
												meanOriginal();
										} else {
											meanOriginal();
										}
										if (currentWidth <= meanScreenWidth) {
												showMeanMenu();
												meanCentered();
										} else {
											meanOriginal();
										}
								});
						}

					jQuery(window).resize(function () {
								// get browser width
								currentWidth = window.innerWidth || document.documentElement.clientWidth;

								if (!isMobile) {
										meanOriginal();
										if (currentWidth <= meanScreenWidth) {
												showMeanMenu();
												meanCentered();
										}
								} else {
										meanCentered();
										if (currentWidth <= meanScreenWidth) {
												if (meanMenuExist === false) {
														showMeanMenu();
												}
										} else {
												meanOriginal();
										}
								}
						});

					// run main menuMenu function on load
					showMeanMenu();
				});
		};
})(jQuery);