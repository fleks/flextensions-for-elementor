/*jQuery('dt').on('mouseover', function(){
    jQuery(this).attr('style', 'position: relative; right: 200px');
    jQuery(this).next().attr('style', 'position: relative; right: 200px')
});

jQuery('dt').on('mouseout', function(){
    jQuery(this).attr('style', 'position: relative; right: 0px');
    jQuery(this).next().attr('style', 'position: relative; right: 0px')
});*/

jQuery( '.flextensions-side-button' ).each( function(i, obj) {
    var listPairs = jQuery( obj ).attr( 'class' ).replace( 'flextensions-side-button ', '' );
    var listSide = jQuery( obj ).data( 'side' );
    var listSideDistance = jQuery( obj ).parent().parent().parent().parent().css( listSide );
    var listWidthDt = jQuery( obj ).css( 'width' )
    var listWidthDd = jQuery( obj ).next().css( 'width' );
    jQuery( '.' + listPairs ).bind('mouseenter', function() {
        jQuery( '.' + listPairs ).attr( 'style', listSide + ': calc( ( ' + listSideDistance + ' ) * ( -1 ) );' );
        console.log(listPairs);
    });
    jQuery( '.' + listPairs ).bind('mouseleave', function() {
            jQuery( '.' + listPairs ).attr( 'style', listSide + ': 0px;' );

        console.log(listPairs);
    });
});