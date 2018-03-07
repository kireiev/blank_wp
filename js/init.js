$(document).ready(function ($) {
    $(this).on('click', '.wpcf7-not-valid-tip', function(){
        $(this).prev().trigger('focus');
        $(this).fadeOut(500,function(){
            $(this).remove();
        });
    });
    $(".menuopen").click(function() {
        $(this).toggleClass("menu_animate");
        $(this).next().stop().slideToggle(300);
        return false;
    });
    var swiper = new Swiper('.slider .swiper-container', {
        pagination: '.slider .swiper-pagination',
        paginationClickable: true,
        speed: 800
    });


});
$(window).load(function(){

});
$(window).resize(function(){

});
