$('.fa-minus').click(function (e) {
    $(this).closest('.box').children('.box-body').slideToggle(500);
    if ( $(this).hasClass('fa-minus') ) {
        $(this).removeClass('fa-minus');
        $(this).addClass('fa-plus');
    } else if ($(this).hasClass('fa-plus')) {
        $(this).removeClass('fa-plus');
        $(this).addClass('fa-minus');
    }
});