'use strict';

class Doc {

    constructor() {
        this.collapseSelector = 'fa-long-arrow-down';
        this.uncollapseSelector = 'fa-long-arrow-up';
        this.constructor.expandSingleEvent();
        this.expandEvent();
    }

    static expandSingleEvent() {
        let modulesDocHeader = document.getElementsByClassName('module-doc__header');

        if (modulesDocHeader.length > 0) {
            for (let i = 0; i < modulesDocHeader.length; i++) {
                modulesDocHeader[i].addEventListener('click', function () {
                    let moduleDocBody = this.parentElement.getElementsByClassName('module-doc__body')[0];
                    let moduleDocBodyClassList = moduleDocBody.classList;
                    moduleDocBodyClassList.toggle('display-none');
                });
            }
        }
    }

    expandEvent() {
        let self = this;
        let expandLinkAllDomObject = document.getElementsByClassName('expand__link-all');
        let expandBlockDomObject = document.getElementsByClassName('expand__block');
        let collapseAll;

        if (expandLinkAllDomObject.length > 0 && expandBlockDomObject.length > 0) {
            expandLinkAllDomObject[0].addEventListener('click', function () {

                if (this.classList.contains(self.collapseSelector)) {
                    this.classList.remove(self.collapseSelector);
                    this.classList.add(self.uncollapseSelector);
                    collapseAll = true;
                } else {
                    this.classList.remove(self.uncollapseSelector);
                    this.classList.add(self.collapseSelector);
                    collapseAll = false;
                }

                for (let i = 0; i < expandBlockDomObject.length; i++) {
                    if (collapseAll) {
                        expandBlockDomObject[i].classList.remove('display-none')
                    } else {
                        expandBlockDomObject[i].classList.add('display-none')
                    }
                }
            });
        }
    }
}

document.addEventListener("DOMContentLoaded", new Doc);
