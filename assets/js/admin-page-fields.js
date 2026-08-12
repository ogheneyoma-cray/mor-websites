/**
 * Generic image-picker wiring for the "Page Content" meta boxes
 * (inc/page-content-fields.php). Any element with class
 * .mor-image-field wraps: a hidden input (attachment ID), a
 * .mor-image-field__preview <img>, a "Select" button, and a "Remove"
 * button. Uses the core wp.media frame — no external dependency.
 */
( function ( $ ) {
	'use strict';

	if ( typeof wp === 'undefined' || ! wp.media ) {
		return;
	}

	$( document ).on( 'click', '.mor-image-field__select', function ( e ) {
		e.preventDefault();
		var $field = $( this ).closest( '.mor-image-field' );
		var $input = $field.find( 'input[type="hidden"]' );
		var $preview = $field.find( '.mor-image-field__preview' );

		var frame = wp.media( {
			title: $field.data( 'title' ) || 'Select Image',
			multiple: false,
			library: { type: 'image' },
			button: { text: 'Use This Image' },
		} );

		frame.on( 'select', function () {
			var attachment = frame.state().get( 'selection' ).first().toJSON();
			$input.val( attachment.id ).trigger( 'change' );
			var src = ( attachment.sizes && attachment.sizes.medium ) ? attachment.sizes.medium.url : attachment.url;
			$preview.html( '<img src="' + src + '" alt="">' );
			$field.find( '.mor-image-field__remove' ).show();
		} );

		frame.open();
	} );

	$( document ).on( 'click', '.mor-image-field__remove', function ( e ) {
		e.preventDefault();
		var $field = $( this ).closest( '.mor-image-field' );
		$field.find( 'input[type="hidden"]' ).val( '' ).trigger( 'change' );
		$field.find( '.mor-image-field__preview' ).empty();
		$( this ).hide();
	} );
} )( jQuery );
