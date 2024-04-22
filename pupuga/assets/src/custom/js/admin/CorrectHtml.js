class CorrectHtml {

    constructor(selectors) {
        this.selectors = selectors;
        document.addEventListener("DOMContentLoaded", () => this.init());
    }

    init() {
        this.removeTag();
        this.checkBoxToRadioBox();
    }

    action(selectors, action) {
        let selectorsLength = selectors.length;
        if (selectorsLength > 0) {
            for (let i = 0; i < selectorsLength; i++) {
                let tags = document.querySelectorAll(selectors[i]);
                if (tags.length > 0) {
                    tags.forEach(function (item, ) {
                        action(item)
                    });
                }
            }
        }
    }

    removeTag() {
        let removeTag = this.selectors.removeTag;
        this.action(removeTag, function(item) {
            item.previousSibling.querySelector('input').remove();
        });
    }

    checkBoxToRadioBox() {
        let checkBoxToRadioBox = this.selectors.checkBoxToRadioBox;
        this.action(checkBoxToRadioBox, function(item) {
            item.type = 'radio';
        });
    }
}

new CorrectHtml({
    'removeTag': ["#levelchecklist > li:not(.popular-category) > .children"],
    'checkBoxToRadioBox': ["#levelchecklist input, #daychecklist input"]
});
