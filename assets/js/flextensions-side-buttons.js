jQuery('dt').on('mouseover', function(){
    jQuery(this).attr('style', 'position: relative; right: 200px');
    jQuery(this).next().attr('style', 'position: relative; right: 200px')
});
jQuery('dt').on('mouseout', function(){
    jQuery(this).attr('style', 'position: relative; right: 0px');
    jQuery(this).next().attr('style', 'position: relative; right: 0px')
});