// Click counter for buttons
var clickCount = {};
// Touch or not
var touchDown = false;

// Extend function
function extend(obj, side, distance) {
    // Extend item to full width
    jQuery(obj).attr('style', side + ': calc( ( ' + distance + ' ) * ( -1 ) );');
}

// Retract function
function retract(side) {
    // Retract all items
    jQuery('dt, dd').attr('style', side + ': 0px;');
    // Remove hover class from all items
    jQuery('dt').parent().removeClass('hover');
    // Set all click counter to default
    for (var key in clickCount) {
        clickCount[key] = 0;
    }
}

jQuery('.flextensions-side-button').each(function (i, obj) {
    // Get item ID-Class
    var listPairs = jQuery(obj).attr('class').replace('flextensions-side-button ', '');
    // Get side of List
    var listSide = jQuery(obj).data('side');
    // Get default distance from browser side
    var listSideDistance = jQuery(obj).parent().parent().parent().parent().css(listSide);
    // Set item click counter to 0
    clickCount[listPairs] = 0;

    // Mouseenter bind for desktop
    jQuery('.' + listPairs).bind('mouseenter', function (e) {
        if (!touchDown) {
            // Add hover class
            jQuery('.' + listPairs).parent().addClass('hover');
            // extend side
            extend('.' + listPairs, listSide, listSideDistance);
        } else {
            // Prevent default for touchscreen
            e.preventDefault();
        }
    });

    // Touch bind for mobile
    jQuery('.' + listPairs).bind('touchstart', function (e) {
        touchDown = true;
        // First click action
        if (clickCount[listPairs] == 0) {
            e.preventDefault();
            // Retract all items and remove hover class
            retract(listSide);
            // Add hover class
            jQuery('.' + listPairs).parent().addClass('hover');
            // Extend item
            extend('.' + listPairs, listSide, listSideDistance);
            clickCount[listPairs] = 1;
        }
        // Second click action
        else if (clickCount[listPairs] == 1) {
            // If icon click action
            if (jQuery(this).hasClass('flextensions-side-button')) {
                e.preventDefault();
                // Retract item immediatly
                retract(listSide);
            }
            else {
                // Retract item with dely of one sec
                setTimeout(function() {
                    retract(listSide);
                }, 1000);
            }
            // Set click counter to default
            clickCount[listPairs] = 0;
        }
    });

    // Mouseleave bind for desktop
    jQuery('.' + listPairs).bind('mouseleave', function () {
        // Retract all items & remove hover class
        retract(listSide);
    });
});
