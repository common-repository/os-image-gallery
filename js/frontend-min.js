jQuery( document ).ready(function($){
	var gallery_type = $( '#gallery_type' ).val();
	if( "lightbox" == gallery_type ) {
		$( ".osig-img" ).colorbox({rel:'osig-img', transition:"elastic", width:"65%"});
	}
	/*$( document ).on( 'click', ".os-image-gallery-nav li a", function() {
		$( 'spinner' ).show();
		var href			=	$( this ).attr( "href" );
		href				=	href.split( '#' );
		catslug				=	href[1];
		$( ".os-image-gallery-nav li a.active" ).removeClass( 'active' );
		$( this ).addClass( 'active' );
		
		if( catslug == 'all' ) {
			$( '.os-image-gallery-box.hide' ).fadeIn( 'normal' ).removeClass( 'hide' );
		} else {
			$( '.os-image-gallery-box' ).each(function() {
				if( !$( this ).hasClass( catslug ) ) {
					$( this ).fadeOut( 'normal' ).addClass( 'hide' );    
				} else {
					$( this ).fadeIn( 'normal' ).removeClass( 'hide' );
				}
			});
		}
		return false;
	}); */
	if( "isotope" == gallery_type ) {
		var filterList = {		
			init: function () {
				$( '.os-image-gallery-wrap' ).mixitup({
					targetSelector: '.os-image-gallery-box',
					filterSelector: '.filter',
					effects: ['fade'],
					easing: 'snap'
				});							
			}
		};
		filterList.init();
	}
	if( "masonry" == gallery_type ) {
		$( '.os-image-gallery-wrap' ).masonry({
			itemSelector: '.os-image-gallery-box'
		});
	}
});	