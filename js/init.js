function screen(method){
    'use strict';
    if(method === 'height') {
        method = window.innerHeight || document.documentElement.clientHeight;
    } else if(method === 'width') {
        method = document.body.offsetWidth;
    } else {
        method = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    }
    return method;
}
function skrollrBuild(){
    'use strict';
    var skr0llr = skrollr.get();
    if (screen('width') > 1024-scroll_width()){
        var skr0llr = skrollr.init({
            forceHeight: false,
            mobileCheck: function() {
                //hack - forces mobile version to be off
                return false;
            }
        });
    } else {
        if(skr0llr) skr0llr.destroy();
    }
}

$(document).ready(function ($) {
    var toggleMenu = function(){
        if (swiper.previousIndex == 0)
            swiper.slidePrev()
    }
        , menuButton = document.getElementsByClassName('menu-button')[0]
        , swiper = new Swiper('.swiper-container', {
        slidesPerView: 'auto'
        , initialSlide: 1
        , resistanceRatio: .00000000000001
        , onSlideChangeStart: function(slider) {
            if (slider.activeIndex == 0) {
                menuButton.classList.add('cross')
                menuButton.removeEventListener('click', toggleMenu, false)
            } else
                menuButton.classList.remove('cross')
        }
        , onSlideChangeEnd: function(slider) {
            if (slider.activeIndex == 0)
                menuButton.removeEventListener('click', toggleMenu, false)
            else
                menuButton.addEventListener('click', toggleMenu, false)
        }
        , slideToClickedSlide: true
    });

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
$( window ).load(function(){
    //skrollrBuild();
});
$(window).resize(function(){
    //skrollrBuild();
});
