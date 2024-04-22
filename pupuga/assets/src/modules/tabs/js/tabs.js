'use strict';

class Tabs {

    constructor(blockName) {
        this.blockName = blockName;
        document.addEventListener("DOMContentLoaded", () => this.init());
    }

    init() {
        this.setVars();
        this.actionClick();
    }

    setVars() {
        this.titleName = this.blockName + '__title';
        this.titleNameActive = this.titleName + '--active';
        this.titleNameObjects = document.getElementsByClassName(this.titleName);
        this.textName = this.blockName + '__text';
        this.textNameActive = this.textName + '--active';
        this.textNameObjects = document.getElementsByClassName(this.textName);
    }

    actionClick() {
        let self = this;
        this.titleNameObjectsLength = this.titleNameObjects.length;
        if (this.titleNameObjectsLength > 0) {
            for (let i = 0; i < this.titleNameObjectsLength; i++) {
                this.titleNameObjects[i].addEventListener('click', function () {self.changeActive(this, i)});
            }
        }
    }

    changeActive(object, i) {
        if (!object.classList.contains(this.titleNameActive)) {
            document.getElementsByClassName(this.titleNameActive)[0].classList.remove(this.titleNameActive);
            document.getElementsByClassName(this.textNameActive)[0].classList.remove(this.textNameActive);
            object.classList.add(this.titleNameActive);
            this.textNameObjects[i].classList.add(this.textNameActive);
        }
    }
}

new Tabs('block-module-tabs');




