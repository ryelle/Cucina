/* global document, jQuery */

/**
 * ui.js
 *
 * Tweak UI effects
 */
( function( $ ) {
	'use strict';

	if ( ! document.getElementById( 'comments' ) ) {
		return;
	}

	var comments = $( document.getElementById( 'comments' ).querySelectorAll( '.parent.comment' ) ),
		addReplyConnectors = function( index, element ){
			var height,
				replies = $(element).find( '> .children > .comment > article' );
			if ( ! replies.length ) {
				return;
			}

			$( element ).find( ' > .reply-connector' ).remove();

			height = ( replies.eq(-1).offset().top - $( element ).offset().top ) + 1;
			$( '<div>' ).addClass('reply-connector').prependTo( element ).css({ height: height + 'px' });
		};

	comments.each( addReplyConnectors );

	$( '.comment-reply-link, #cancel-comment-reply-link' ).on( 'click', function(){
		setTimeout( function(){
			comments.each( addReplyConnectors );
		}, 100 );
	});

	$( document.getElementById( 'comments' ) ).removeClass('no-js');

} )( jQuery );
