/**
 * ui.js
 *
 * Tweak UI effects
 */
( function( $ ) {
	if ( ! document.getElementById( 'comments' ) ) {
		return;
	}

	var comments = $( document.getElementById( 'comments' ).querySelectorAll( '.parent.comment' ) );

	comments.each(function( index, element ){
		var height,
			replies = $(element).find( '> .children > .comment > article' );
		if ( ! replies.length ) {
			return;
		}

		height = ( replies.eq(-1).offset().top - $( element ).offset().top ) + 1;
		$( '<div>' ).addClass('reply-connector').prependTo( element ).css({ height: height + 'px' });
	});

	$( document.getElementById( 'comments' ) ).removeClass('no-js');

} )( jQuery );
