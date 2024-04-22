'use strict';

let $ = jQuery;

class Sitemap {

    constructor(config) {
        this.config = config;
        this.generateTag = config.generate;
        this.saveTag = config.save;
        this.actionObjects = $(this.generateTag + ', ' + this.saveTag);
        this.waitingObject = $('.pupuga-waiting');
        this.messageObject = $('.pupuga-admin-page__messages');
        this.textareaObject = $('.pupuga-color-textarea');
        this.classTableDisableRows = '.pupuga-admin-table__tr--disable';
        this.classTableChangedForms = '.pupuga-admin-table__form-element--changed';
        this.init();
    }

    init() {
        this.actionObjects.off('click').on('click', (e) => {
            this.action(e.currentTarget);
            return false;
        });
    }

    startAjax() {
        this.waitingObject.removeClass('display-none-force');
    }

    endAjax() {
        this.waitingObject.addClass('display-none-force');
    }

    getExcluded(objects) {
        let excludes = [];
        objects.each(function () {
            let id = $(this).attr('data-id');
            excludes.push(parseInt(id));
        });

        return excludes;
    }

    getChanged(objects) {
        let changed = {
            period: {},
            priority: {}
        };
        objects.each(function () {
            let $this = $(this);
            let id = $this.attr('data-id');
            let property = $this.attr('name');
            changed[property][parseInt(id)] = $this.val();
        });

        return changed;
    }

    setMessage(message) {
        let self = this;
        this.messageObject.html('<div id="message" class="updated notice is-dismissible"><p><strong>' + message + '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>');
        this.messageObject.find('button').off().on('click', function () {
            self.messageObject.html('');
        });
    }

    saveToView(data) {
        if (this.textareaObject.length > 0) {
            this.textareaObject.removeClass('display-none').text(data);
        }
    }

    action(tag) {
        let action = $(tag).data('action');
        let excluded = this.getExcluded($(this.classTableDisableRows));
        let changed = this.getChanged($(this.classTableChangedForms));
        let self = this;
        //console.log(changed);
        this.startAjax();
        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: {
                action: 'map',
                type: action,
                excluded: JSON.stringify(excluded),
                changed: JSON.stringify(changed),
            },
            success: function (data) {
                switch (data) {
                    case 'save' :
                        self.setMessage('Sitemap was created');
                        break;
                    default :
                        self.saveToView(data);
                }
                self.endAjax();
            }
        });
        $('html, body').animate({
            scrollTop: $('#wpcontent').offset().top
        }, 100);
    }
}

export default Sitemap;