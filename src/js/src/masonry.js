/* global document, jQuery, Masonry, imagesLoaded */

/**
 * masonry.js
 *
 * Initialize Masonry
 */
( function( $ ) {
	'use strict';

	var container = document.querySelectorAll('.masonry'),
		msnry;

	if ( ! container.length ) {
		return;
	}

	// initialize Masonry after all images have loaded
	imagesLoaded( container, function() {
		if ( container.length > 1 ){
			$( container ).each( function( index, element ){
				msnry = new Masonry( element, {
					itemSelector: '.hentry',
					gutter: 35,
					transitionDuration: 0
				});
			});
		} else {
			msnry = new Masonry( container[0], {
				itemSelector: '.hentry',
				gutter: 35,
				transitionDuration: 0
			});
		}
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
