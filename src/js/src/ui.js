/**
 * ui.js
 *
 * Tweak UI effects
 */
( function( $ ) {
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

			height = ( replies.eq(-1).offset().top - $( element ).offset().top ) + 1;
			$( '<div>' ).addClass('reply-connector').prependTo( element ).css({ height: height + 'px' });
		};

	comments.each( addReplyConnectors );

	$( ".comment-reply-link, #cancel-comment-reply-link" ).on( 'click', function(){
		var comment = $( this ).closest( ".parent.comment" );
		setTimeout( function(){
			comment.find( ".reply-connector" ).remove();
			addReplyConnectors( 0, comment );
		}, 100 );
	});

	$( document.getElementById( 'comments' ) ).removeClass('no-js');

} )( jQuery );
