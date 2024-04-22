let $ = jQuery;
let blockSelector = ".modal--show";

let coreTagName = "sample-sources";
let coreTag = blockSelector + " ." + coreTagName;

let fieldTagName = coreTagName + "__field";
let fieldTagNameError = fieldTagName + "--error";
let fieldTag = coreTag + " ." + fieldTagName;
let fields;
let fieldValues = {};

let patterns = {
    email : /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
};

function checkField(value, pattern) {
    return pattern.test(value);
}

function checkFields() {
    let result = true;
    fields = document.querySelectorAll(fieldTag);
    fields.forEach(function (el, i, array) {
        let fieldValue = el.value.trim();
        fieldValues[el.getAttribute('data-name')] = fieldValue;
        if (fieldValue !== '') {
            let pattern = patterns[el.getAttribute('type')];
            if (pattern !== undefined) {
                if (!checkField(fieldValue, pattern)) {
                    el.classList.add(fieldTagNameError);
                    if (result) {
                        result = false;
                    }
                }
            }
        } else {
            el.classList.add(fieldTagNameError);
            result = false;
        }
    });

    return result;
}

function sendSubscriber(e) {
    let data = {
        nonce: globalVars.nonce,
        action: 'setSubscriber',
        fields: fieldValues,
        page: e.target.getAttribute('data-link')
    };
    let waitingObject = document.querySelector(coreTag + '__waiting');
    let messageObject = document.querySelector(coreTag + '__message');
    let formObject = document.querySelector(coreTag + '__before-result form');
    formObject.remove();
    waitingObject.classList.remove('display-none');
    $.ajax({
        url: globalVars.url,
        type: "POST",
        data: data,
        success: function (data) {
            waitingObject.remove();
            messageObject.classList.remove('display-none');
        }
    });
}

function registerEmail(e) {
    if (e.target.classList.contains(coreTagName + "__submit")) {
        if (checkFields()) {
            sendSubscriber(e);
        }
        e.preventDefault();
    }
    if (e.target.classList.contains(coreTagName + "__field")) {
        e.target.classList.remove(fieldTagNameError);
    }
}

document.addEventListener("click", registerEmail);