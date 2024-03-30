"use strict";
// Class definition

var KTCkeditorInline = function () {
    // Private functions
    var demos = function () {
        InlineEditor
			.create( document.querySelector( '#kt-ckeditor-1' ) )
			.then( editor => {
				console.log( editor );
			} )
			.catch( error => {
				console.error( error );
			} );

        InlineEditor
			.create( document.querySelector( '#kt-ckeditor-2' ) )
			.then( editor => {
				console.log( editor );
			} )
			.catch( error => {
				console.error( error );
			} );

		InlineEditor
			.create( document.querySelector( '#kt-ckeditor-3' ) )
			.then( editor => {
				console.log( editor );
			} )
			.catch( error => {
				console.error( error );
			} );

		InlineEditor
			.create( document.querySelector( '#kt-ckeditor-4' ) )
			.then( editor => {
				console.log( editor );
			} )
			.catch( error => {
				console.error( error );
			} );

		InlineEditor
			.create( document.querySelector( '#kt-ckeditor-5' ) )
			.then( editor => {
				console.log( editor );
			} )
			.catch( error => {
				console.error( error );
			} );

        InlineEditor
            .create( document.querySelector( '.global-ckeditor' ) )
            .then( editor => {
                console.log( editor );
                console.log( '//////////// CREATED CUSTOM GLOBAL CKEDITOR //////////////' );
            } )
            .catch( error => {
                console.error( error );
            } );

        console.log('//////////// BUILDING CKEDITORS ////////////////');

    }

    return {
        // public functions
        init: function() {
			demos();
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    KTCkeditorInline.init();
});
