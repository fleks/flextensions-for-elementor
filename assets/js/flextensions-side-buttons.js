/*jQuery('dt').on('mouseover', function(){
    jQuery(this).attr('style', 'position: relative; right: 200px');
    jQuery(this).next().attr('style', 'position: relative; right: 200px')
});

jQuery('dt').on('mouseout', function(){
    jQuery(this).attr('style', 'position: relative; right: 0px');
    jQuery(this).next().attr('style', 'position: relative; right: 0px')
});*/

var clickCount = {};
var touchDown = 0;

jQuery( '.flextensions-side-button' ).each( function(i, obj) {
    var listPairs = jQuery( obj ).attr( 'class' ).replace( 'flextensions-side-button ', '' );
    var listSide = jQuery( obj ).data( 'side' );
    var listSideDistance = jQuery( obj ).parent().parent().parent().parent().css( listSide );
    var listWidthDt = jQuery( obj ).css( 'width' )
    var listWidthDd = jQuery( obj ).next().css( 'width' );
    clickCount[listPairs] = 0;
    jQuery( '.' + listPairs ).bind('mouseenter', function(e) {
        console.log( 'mouseenter' );
        if( touchDown != 1) {
            extend( '.' + listPairs, listSide, listSideDistance );
        }
        else {
            e.preventDefault();
        }
    });
    jQuery( '.' + listPairs ).bind('touchstart', function(e) {
        touchDown = 1;
        clickCount[listPairs] = clickCount[listPairs] + 1;

        if( clickCount[listPairs] == 1 ) {
            e.preventDefault();
            console.log( '1: ' + listPairs );
            retract( 'dt, dd', listSide );
            jQuery( '.' + listPairs ).parent().addClass('hover');
            extend( '.' + listPairs, listSide, listSideDistance );
        }
        else if( clickCount[listPairs] == 2 ) {
            console.log( '2: ' + listPairs );
            retract( 'dt, dd', listSide );
            clickCount[listPairs] = 0;
        }
        
    });

    function extend( obj, side, distance ) {
        console.log( 'extend: ' + obj ); 
        jQuery( obj ).attr( 'style', side + ': calc( ( ' + distance + ' ) * ( -1 ) );' );
    }


    function retract( obj, side ) {
        jQuery( 'dt, dd' ).attr( 'style', side + ': 0px;' );
        jQuery( 'dt' ).parent().removeClass('hover');
        for( var key in touchDown ) {
            touchDown[ key ] = 0;
        }
    }

    jQuery( '.' + listPairs ).bind('mouseleave', function() {
            retract( '.' + listPairs, listSide );
    });
   /* jQuery( '.' + listPairs ).bind('touchend', function() {
        retract( '.' + listPairs, listSide );
    }); */
});