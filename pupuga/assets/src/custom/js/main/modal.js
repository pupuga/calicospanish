let trigger = document.querySelectorAll(".modal-trigger");
let closeButton = document.querySelector(".modal__close");
let modal = document.querySelector(".modal");
let wrapper = null;

function toggleModal(e, self = null) {
    let modalDataSelector = modal.querySelector(".modal__data");
    if (self === null) {
        self = this;
    }
    if (self.getAttribute("data-wrapper") !== null) {
        wrapper = self.getAttribute("data-wrapper");
    }
    if (wrapper !== null) {
        modal.classList.toggle(wrapper);
    }
    if (modalDataSelector.innerHTML === '') {
        let template = this.getAttribute("data-template");
        if (template === null) {
            template = this.getAttribute("data-video").replace('[', '<').replace(']', '>');
        } else {
            template = document.querySelector(template).innerHTML.replace('%%data-link%%', this.getAttribute("data-link"));
        }
        modalDataSelector.innerHTML = template;
    } else {
        modalDataSelector.innerHTML = '';
    }
    modal.classList.toggle("modal--show");
    e.preventDefault();
}

function windowOnClick(e) {
    if (e.target === modal) {
        toggleModal(e, this);
    }
}

function loop(selectors, callback) {
    let selectorsLength = selectors.length;
    if (selectorsLength > 0) {
        for (let i = 0; i < selectorsLength; i++) {
            callback(selectors[i]);
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    loop(trigger, function (el) {
        el.addEventListener("click", toggleModal);
    });
    closeButton.addEventListener("click", toggleModal);
    modal.addEventListener("click", windowOnClick);
});