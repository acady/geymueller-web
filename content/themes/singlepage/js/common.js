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
    var e = function() {
	
        var e = 0,
        t = null,
        n = null,
        r = 0,
        i = 0,
        s = 0,
        o = 0,
        u = $(".sub_nav li"),
		l = u.length,
        a = $("html,body"),
        f = $(window);
        f.resize(function(e) {
            s = $(window).height()
        }).resize(),
        f.scroll(function(t) {
            r = $(this).scrollTop()+1,
            r < .3 * s ? e = 0 : r >= s && r < 1.3 * s ? e = 1 : r >= 2 * s && r < 2.3 * s ? e = 2 : r >= 3 * s && r < 3.3 * s ? e = 3 : r >= 4 * s && r < 4.3 * s ? e = 4 : r >= 5 * s && r < 5.3 * s && (e = 5),
            u.removeClass("cur").eq(e).addClass("cur");
        }),
        a.on("mousewheel",
        function(n) {
            o = window.event.detail ? -(window.event.detail || 0) / 3 : window.event.wheelDelta / 120,
            clearTimeout(t),
            t = setTimeout(function() {
                o > 0 && e > 0 ? e--:o < 0 && e < (l-1) && e++,
                a.animate({
                    scrollTop: s * e
                },
                Number(singlepage_params.scrolldelay), "easeInOutQuart")
            },
            300),
            n.preventDefault()
        }),
        u.on("click",
        function(t) {
            i = $(this).index(),
            a.animate({
                scrollTop: s * i
            },
            Number(singlepage_params.scrolldelay), "easeInOutQuart",
            function() {
                e = i
            });
			
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
})(jQuery)

function singlepageClick(o){ 
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

// onepage nav
/*$('#featured-template #sub_nav_2 li span').each(function(){
     $(this).click(function(){
				singlepageClick($(this).parent('li').find("a").attr("id"));
			});
	 
	});*/

/*
$('#featured-template #sub_nav_2').onePageNav({
		changeHash: false,
		filter: "ul li a[href^='#']",
		currentClass:"cur",
		scrollThreshold:0.15,
		scrollSpeed:Number(singlepage_params.scrolldelay)
	});*/


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
$(document).on("scroll", onScroll);

function onScroll(event){
    var scrollPos = $(document).scrollTop()+1;
    $('#featured-template #sub_nav_2 li a[href^="#"]').each(function () {
																	  
        var currLink = $(this);
		var currLi   = currLink.parent('li');
		
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
		var currLi   = currLink.parent('li');
		
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
$("#featured-template section").each(function(){
											  
  $(this).css({'min-height':$(window).height()});						  
											  
  });
}else{

$("#featured-template section").each(function(){
				$(this).css({'height':$(window).height()});
				});
$( window ).resize(function() {
	$("#featured-template section").each(function(){
				$(this).css({'height':$(window).height()});
				});						
   });
}

////
if( $('#wrapper #main').length && $('#wrapper #side').length  ){
	if( $('#wrapper #main').outerHeight() >  $('#wrapper #side').height()  ){
		$('#wrapper #side').height($('#wrapper #main').outerHeight());
	}
	
	}								
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
 var headerHeight = $('header.navbar').height();
$('header').affix({offset: {top: headerHeight-adminbarHeight}}); 
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
$('.sub_nav ul li a').click(function(e){
							e.preventDefault();		 
						});

/* ------------------------------------------------------------------------ */
/* home page video background														*/
/* ------------------------------------------------------------------------ */
 if( $('section.singlepage-video-section').length && typeof singlepage_video !== 'undefined' ){
		  var video_loop = true ;
		  if( singlepage_video.video_loop === 'false'){
			  video_loop = false;
			  }
		  
	    var BV;
            var BV = new jQuery.BigVideo({
				useFlashForFirefox:false,
				forceAutoplay:true,
				controls:false,
				doLoop:video_loop,
				container: $(".singlepage-video-section")
			});
			BV.init();
			if (Modernizr.touch) {
				BV.show(singlepage_video.poster_url);
			} else {
				BV.show(
				[
        { type: "video/mp4",  src: singlepage_video.mp4_video_url },
        { type: "video/webm", src: singlepage_video.webm_video_url },
        { type: "video/ogg",  src: singlepage_video.ogv_video_url }
    ],{ambient: video_loop});
	BV.getPlayer().volume( singlepage_video.video_volume );
	BV.getPlayer().on("durationchange",function(){jQuery("#big-video-wrap").fadeIn();});
	
			}
	}
		

/* ------------------------------------------------------------------------ */
/* home page full screen google map													*/
/* ------------------------------------------------------------------------ */
 if( $('section.singlepage-google-map-section').length && typeof singlepage_google_map !== 'undefined' && typeof google !== 'undefined' ){
var geocoder;
var map;
function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
  var mapOptions = {
    zoom: Number(singlepage_google_map.google_map_zoom),
    center: latlng
  }
  map = new google.maps.Map(document.getElementById(singlepage_google_map.google_map_wrap), mapOptions);
  codeAddress();
  var trafficLayer = new google.maps.TrafficLayer();
  trafficLayer.setMap(map);
}

function codeAddress() {
  var address = singlepage_google_map.google_map_address;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
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
				//$('#panel-cog i').removeClass('fa-chevron-right').addClass('fa-chevron-left');
				}
				else{
				$(".sub_nav_style2 .sub_nav").addClass("hide-sidebar");	
				//$('#panel-cog i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
					}
       })

// responsive menu
  if( $('header nav > ul').length )
  $('header nav,#navigation nav').meanmenu({meanScreenWidth:919});
/* ------------------------------------------------------------------------ */
/*  smooth scrolling  btn       	  								  	    */
/* ------------------------------------------------------------------------ */
/*
   jQuery("header a[href^='#']").on('click', function(e){
				var selectorHeight = jQuery('header').height();   
				var scrollTop = jQuery(window).scrollTop(); 
				e.preventDefault();
		 		var id = jQuery(this).attr('href');
				if(typeof jQuery(id).offset() !== 'undefined'){
				if( $("#featured-template").length ){
					var goTo = jQuery(id).offset().top;
					}else{
				    var goTo = jQuery(id).offset().top - selectorHeight;
				}
				jQuery("html, body").animate({ scrollTop: goTo }, 1000);
				}

 });	
  */
/* ------------------------------------------------------------------------ */
/* home page youtube video 	  								  	    */
/* ------------------------------------------------------------------------ */ 
  if( $('#home_youtube_video').length){
	  $.mbYTPlayer.apiKey = "AIzaSyB_z8WrsKw2kIplh5kBc6xTawEDu91V5dQ";
	var myPlayer;
	 myPlayer  = $('#home_youtube_video').YTPlayer();
	}
  

 });


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
