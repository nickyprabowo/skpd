jQuery( function( $ ){
    $('.filter-results')
        .keyup( function( ){ filterResults() } )
        .change( function( ){ filterResults() } );

    var filterResults = function(){
        var filter = $('.filter-results').val().toLowerCase();

        if( filter == '' ) {
            $('.importer-pack').show();
        }
        else {
            $('.importer-pack')
                .hide()
                .filter( function( i, el ){
                    return $( el ).find( 'h3' ).html().toLowerCase().indexOf( filter ) > -1;
                } )
                .show();
        }
    }
} );