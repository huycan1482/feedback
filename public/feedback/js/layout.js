$('.account-toggle').click(function (e) {
    $('.drop-menu').slideToggle(500);
    // $(this).children('.fa-sort-down').css('transform', 'rotate(180deg)');
});

$('.sidebar-toggle').click(function (e) {
    $('.navbar').toggleClass('navbar-move');
});

window.addEventListener("scroll",function(){
    var x = pageYOffset;
        
    // kéo xuống
    if(x > 100){
        $('.scroll-up').fadeIn();
    } else {
        $('.scroll-up').fadeOut();
    }

});

$('.scroll-up').click( function (e) {
    // $('header').scrollTop(600);
    // console.log(true);
    $('html, body').animate({
        scrollTop: top +100
    }, 'slow');
});