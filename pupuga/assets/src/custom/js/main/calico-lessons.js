import "../../scss/main/calico-lessons.scss";
import "slider-pro/dist/css/slider-pro.css";
import "slider-pro";

let $ = jQuery;

$( document ).ready(function($) {
   $('.arrow-rectangle-block__module-slider-pro').sliderPro({
       width: 500,
       height: 500,
       autoplay:  false,
       autoplayOnHover: 'none',
       autoplayDelay: 5000,
       arrows: true,
       buttons: true,
       smallSize: 300,
       mediumSize: 1000,
       largeSize: 3000,
       fade: true,
       thumbnailArrows: true,
       thumbnailWidth: 120,
       thumbnailHeight: 120,
       thumbnailsPosition: 'bottom',
       centerImage: true,
       allowScaleUp: true,
       startSlide: 0,
       loop: true,
       slideDistance: 5,
       autoplayDirection: 'normal',
       touchSwipe: true,
       fullScreen: true,
       init: function () {
           $('.arrow-rectangle-block__module-slider-pro').css('opacity', 1);
       }
    });

    $('.resources-list__module-slider-pro').sliderPro({
        width: 432,
        height: 432,
        autoplay:  false,
        autoplayOnHover: 'none',
        autoplayDelay: 5000,
        arrows: true,
        buttons: true,
        smallSize: 300,
        mediumSize: 1000,
        largeSize: 3000,
        fade: true,
        thumbnailArrows: true,
        thumbnailWidth: 83,
        thumbnailHeight: 83,
        thumbnailsPosition: 'bottom',
        centerImage: true,
        allowScaleUp: true,
        startSlide: 0,
        loop: true,
        slideDistance: 5,
        autoplayDirection: 'normal',
        touchSwipe: true,
        fullScreen: true,
        init: function () {
            $('.resources-list__module-slider-pro').css('opacity', 1);
        }
    });

    $('.round-arrow-rectangle-block__link:not(.round-arrow-rectangle-block__link--disable), .days-tabs__item, .controls-prev-next__control').on('click', function () {
        $(this).find('form').submit();
    });

    $('.link-level-form').on('click', function () {
        $('.level-form').submit();

        return false;
    });

});

$(window).load(function () {
    audiojs.events.ready(function () {
        audiojs.createAll();
    });
});