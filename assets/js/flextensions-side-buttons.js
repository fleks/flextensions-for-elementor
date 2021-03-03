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
    jQuery( '.' + listPairs ).bind('mouseenter', function() {
        jQuery( '.' + listPairs ).attr( 'style', 'position: relative; right: 210px;');
        console.log(listPairs);
    });
    jQuery( '.' + listPairs ).bind('mouseleave', function() {
        jQuery( '.' + listPairs ).attr( 'style', 'right: 0px;' );
        console.log(listPairs);
    });
});