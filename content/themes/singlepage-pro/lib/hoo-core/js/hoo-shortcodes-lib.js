jQuery(document).ready(function($) {	
/*  $(".wow").each(function(){
	var duration = $(this).data("animationduration");
       if( typeof duration !== "undefined"){
		   $(this).css({"-webkit-animation-duration":duration+"s","animation-duration":duration+"s"});
		   }
    })*/
  
  
  	// Testimonials
	function onBefore( curr, next, opts, fwd ) {
	  var $ht = jQuery( this ).height();

	  //set the active testimonial class for resize event
	  jQuery( this ).parent().children().removeClass( 'active-testimonial' );
	  jQuery( this ).addClass( 'active-testimonial' );

	  //set the container's height to that of the current slide
	  jQuery( this ).parent().animate( { height: $ht }, 500 );
	}

	if ( jQuery().cycle ) {
		var reviews_cycle_args = {
			fx: 'fade',
			before:  onBefore,
			containerResize: 0,
			containerResizeHeight: 1,
			height: 'auto',
			width: '100%',
			fit: 1,
			speed: 500,
			delay: 0
		};

	
		reviews_cycle_args.pager = '.testimonial-pagination';

		jQuery( '.singlepage-testimonials .reviews' ).each( function() {
			if ( jQuery( this ).children().length == 1 ) {
				jQuery( this ).children().fadeIn();
			}

			reviews_cycle_args.pager = '#' + jQuery( this ).parent().find( '.testimonial-pagination' ).attr( 'id' );

			reviews_cycle_args.random = jQuery( this ).parent().data( 'random' );
			jQuery( this ).cycle( reviews_cycle_args );
		});



		jQuery( window ).resize( function() {
			jQuery( '.singlepage-testimonials .reviews' ).each( function() {
				jQuery( this ).css( 'height', jQuery( this ).children( '.active-testimonial' ).height() );
			});
		});
	}
								
});