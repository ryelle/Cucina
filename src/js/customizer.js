/* global wp, jQuery */

/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	'use strict';

	var header = '.site-title a:link, .site-title a:active, .site-title a:hover, .site-title a:visited',
	    description = '.site-description';

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).addClass('screen-reader-text');
			} else {
				$( '.site-title, .site-description' ).removeClass('screen-reader-text');
				$( header ).css({ color: to });
			}
		} );
	} );

	// Description text color.
	wp.customize( 'desc_textcolor', function( value ) {
		value.bind( function( to ) {
			$( description ).css({ color: to });
		} );
	} );
} )( jQuery );
