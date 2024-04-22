import * as cookies from 'browser-cookies';

function offInfo() {
    setCookie();
    hideBanner();
}

function setCookie() {
    cookies.set('gdpr', '1', {expires: 365});
}

function hideBanner() {
    document.querySelector('.pupuga-gdpr').classList.add('display-none-force');
}

document.addEventListener('DOMContentLoaded', function() {
    let submit = document.querySelector('.pupuga-gdpr__submit button');
    if (submit !== null) {
        submit.addEventListener('click', offInfo);
    }
});
