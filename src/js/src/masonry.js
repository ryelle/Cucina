/**
 * masonry.js
 *
 * Initialize Masonry
 */
( function( $ ) {
	var container = document.querySelector('#masonry');
	var msnry;

	if ( ! container ) {
		return;
	}

	// initialize Masonry after all images have loaded
	imagesLoaded( container, function() {
		msnry = new Masonry( container, {
			itemSelector: '.hentry',
			gutter: 50,
			transitionDuration: 0
		});
	});

	$( document ).on( 'post-load', function( event, response ){
		if ( 'success' == response.type ) {
			imagesLoaded( container, function() {
				msnry.reloadItems();
				msnry.layout();
			});
		}
	});

} )( jQuery );
