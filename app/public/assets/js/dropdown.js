$(document).ready(function () {
    $('.dropdown-toggle2').mouseover(function() {
        $('.dropdown-menu').show();
    })

    $('.dropdown-toggle2').mouseout(function() {
        t = setTimeout(function() {
            $('.dropdown-menu').hide();
        }, 100);

        $('.dropdown-menu').on('mouseenter', function() {
            $('.dropdown-menu').show();
            clearTimeout(t);
        }).on('mouseleave', function() {
            $('.dropdown-menu').hide();
        })
    })
})