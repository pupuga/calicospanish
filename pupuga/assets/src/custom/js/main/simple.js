let $ = jQuery;

document.addEventListener('DOMContentLoaded', function() {
    /* menu */
    let html = '';

    let menus = [
        '.pupuga-list-block--categories',
        '.pupuga-list-block--archives',
        '.pupuga-list-block--tags',
/*      '.general__header--bottom .user-guest .general__menu--right',
        '.general__footer-bottom .general__menu--separators'*/
    ];
    if (menus.length > 0) {
        menus.forEach(function (el) {
            let elObject = $(el);
            if (elObject.length > 0) {
                html = html + '<li class="menu-item-has-children">' + $(el).html() + '</li>';
            }
        });
        html = '<ul>' + html + '</ul>';
    }

    $('.mobile-menu__block--auto').html(html);

    $('.menu-item-has-children > a, .mobile-menu__block li > h3').off().on
    ('click', function () {
        $(this).next('ul').toggleClass('sub-menu--open');

        return false;
    });

    /* responsive button */
    $('.responsive-button').off().on('click', function () {
        $(this).toggleClass('responsive-button--open');
        $(this).find('.responsive-button__line').toggleClass('responsive-button__line--open');
        $('.mobile-menu').toggleClass('mobile-menu--open');
    });

    let bodyColorBlue = $('.background-body-blue');
    if (bodyColorBlue.length > 0) {
        $('.general').addClass('background-body-blue');
    }

    /* Checkout & My Account Pages Placeholders */
    let checkoutPageLabels = $('.shop-checkout-page label, .pupuga-account-content label');
    if (checkoutPageLabels.length > 0) {
        checkoutPageLabels.each(function (i, el) {
            $(el).find('.optional').remove();
            let text = el.innerText;
            $(el).next().find('input').attr('placeholder', text);
        });
    }

    /* Correcting free-trial links */
    let freeTrialLinks = $('a.button, .button-wrapper a');
    if (freeTrialLinks.length > 0) {
        let freeTrialId = globalData.freeTrialProduct;
        $.each(freeTrialLinks, function( key, link ) {
            let linkObject = $(link);
            let linkText = linkObject.text();
            let linkTextTransform = linkText.toLowerCase();
            if (linkObject.attr('href') === '#' && linkTextTransform.search('free') !== -1) {
                linkObject.attr('href', '/?add-to-cart=' + freeTrialId);
            }
        })
    }
});

$(window).load(function () {
    $(".image-stretch-full").each(function (i, el) {
        let img = $(el).find('img');
        let srcImg = img.attr('src');
        $(el).find('.block-module-redactor:first-child').css('background-image', 'url(' + srcImg + ')');
    });
});



/* Correcting text */
let checkoutTag = document.querySelector(".woocommerce-checkout");
let observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.type === 'attributes') {
            mutation.target.childNodes.forEach(function (el) {
                if (el.innerText === 'An account is already registered with your email address. Please log in.') {
                    document.querySelector('.woocommerce-error li').innerHTML = 'An account is already registered with your email address. <a href="/my-account/"><strong>Please log in<strong></strong></a>';
                }
            });
        }
    });
});
if (typeof(checkoutTag) != 'undefined' && checkoutTag != null) {
    observer.observe(checkoutTag, {
        attributes: true,
        childList: true,
        characterData: true
    });
}