//-----SCRIPT CAROUSEL FILTER ----------------------------------------------------------------

$(document).ready(function () {

    var w = window.innerWidth;

    var mqMayor320 = { // > 320
        forcedImageWidth:100,
        forcedImageHeight:100,
        separationMultiplier: 0.6,
        separation: 70
    };

    var mqMenur414 = { // < 600
        forcedImageWidth:150,
        forcedImageHeight:150,
        separationMultiplier: 0.6,
        separation: 100
    };

    var mqMenur600 = { // < 600
        forcedImageWidth:200,
        forcedImageHeight:200,
        separationMultiplier: 0.6,
        separation: 120
    };

    var defect = { // < 600
        forcedImageWidth:0,
        forcedImageHeight:0,
        separationMultiplier: 0.6,
        separation: 175
    };

    var finalSize;
    if (w > 320 && w < 414) {
        finalSize = mqMayor320;
    }else if (w > 414 && w < 600) {
        finalSize = mqMenur414;
    } else if (w > 600 && w < 767) {
        finalSize = mqMenur600;
    } else if (w > 767) {
        finalSize = defect;
    }

    var carousel = $("#carousel").waterwheelCarousel({
        flankingItems: 3,
        forcedImageWidth: finalSize['forcedImageWidth'],
        forcedImageHeight: finalSize['forcedImageHeight'],
        separationMultiplier: finalSize['separationMultiplier'],
        separation: finalSize['separation'],
        movingToCenter: function ($item) {
            $('#callback-output').prepend('movingToCenter: ' + $item.attr('id') + '<br/>');
        },
        movedToCenter: function ($item) {
            $('#callback-output').prepend('movedToCenter: ' + $item.attr('id') + '<br/>');
        },
        movingFromCenter: function ($item) {
            $('#callback-output').prepend('movingFromCenter: ' + $item.attr('id') + '<br/>');
        },
        movedFromCenter: function ($item) {
            $('#callback-output').prepend('movedFromCenter: ' + $item.attr('id') + '<br/>');
        },
        clickedCenter: function ($item) {
            window.location.href = baseUrl+'/buscador?type=Venta&propiedad='+$item[0].dataset.type+'';
            $('#callback-output').prepend('clickedCenter: ' + $item.attr('id') + '<br/>');
        }
    });

    $('#prev').bind('click', function () {
        carousel.prev();
        return false
    });

    $('#next').bind('click', function () {
        carousel.next();
        return false;
    });

    $('#reload').bind('click', function () {
        newOptions = eval("(" + $('#newoptions').val() + ")");
        carousel.reload(newOptions);
        return false;
    });
});

//------SELECT2 -----------------------------------------------------------------------------

$(document).ready(function() {
    $('.js-example-basic-multiple').select2({
        placeholder: 'Seleccionar',
    });
});

//------RANGE PRICE --------------------------------------------------------------------------

// With JQuery
/*
$("#ex2").slider({});
*/

//------ SEARCH INPUT ------------------------------------------------------------------------
