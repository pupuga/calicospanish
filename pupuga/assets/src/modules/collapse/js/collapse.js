'use strict';

class Collapse {

    constructor(blockName) {
        this.blockName = blockName;
        document.addEventListener("DOMContentLoaded", () => this.init());
    }

    init() {
        this.setVars();
        this.actionAllClick();
        this.actionItemClick();
    }

    setVars() {
        this.titleNameAll = this.blockName + '__collapse-expand-all';
        this.titleNameAllOpen = this.titleNameAll + '--open';
        this.titleNameAllObjects = document.getElementsByClassName(this.titleNameAll);
        this.titleName = this.blockName + '__title';
        this.titleNameOpen = this.titleName + '--open';
        this.titleNameObjects = document.getElementsByClassName(this.titleName);
        this.textName = this.blockName + '__text';
        this.textNameOpen = this.textName + '--open';
        this.textNameObjects = document.getElementsByClassName(this.textName);
    }

    actionAllClick() {
        let self = this;
        this.titleNameAllObjectsLength = this.titleNameAllObjects.length;
        if (this.titleNameAllObjectsLength > 0) {
            for (let i = 0; i < this.titleNameAllObjectsLength; i++) {
                this.titleNameAllObjects[i].addEventListener('click', function (e) {
                    self.toggleAll(this);
                    e.preventDefault()
                });
            }
        }
    }

    toggleAll(object) {
        this.textNameObjectsLength = this.textNameObjects.length;
        if (this.textNameObjectsLength > 0) {
            object.classList.toggle(this.titleNameAllOpen);
            for (let i = 0; i < this.textNameObjectsLength; i++) {
                let titleNameObject = this.titleNameObjects[i];
                let textNameObject = this.textNameObjects[i];
                if (object.classList.contains(this.titleNameAllOpen)) {
                    titleNameObject.classList.add(this.titleNameOpen);
                    textNameObject.classList.add(this.textNameOpen);
                } else {
                    titleNameObject.classList.remove(this.titleNameOpen);
                    textNameObject.classList.remove(this.textNameOpen);
                }
            }
        }
    }

    actionItemClick() {
        let self = this;
        this.titleNameObjectsLength = this.titleNameObjects.length;
        if (this.titleNameObjectsLength > 0) {
            for (let i = 0; i < this.titleNameObjectsLength; i++) {
                this.titleNameObjects[i].addEventListener('click', function () {self.toggleItem(this, i)});
            }
        }
    }

    toggleItem(object, i) {
        object.classList.toggle(this.titleNameOpen);
        this.textNameObjects[i].classList.toggle(this.textNameOpen);
    }
}

new Collapse('block-module-collapse');