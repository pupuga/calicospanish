'use strict';

let $ = jQuery;

class Table {

    constructor(selectors) {
        this.selectors = selectors;
        this.filterObjects = $(this.selectors.filter);
        this.tableObjects = $(this.selectors.table);
        this.tableCheckboxObjects = $('.pupuga-input-table--checkbox');
        this.tr = this.selectors.table + '__tr';
        this.classTableDisableRow = this.tr + '--disable';
        this.classTableChangedForm = '.pupuga-admin-table__form-element';
        this.init();
    }

    init() {
        $('.pupuga-admin-page__table').removeClass('display-none-force');
        this.filterObjects.off('click').on('click', () => this.filterType());
        this.tableCheckboxObjects.off('change').on('change', (e) => this.rowOnOffStyle($(e.currentTarget)));
        $(this.classTableChangedForm).off('change').on('change', (e) => this.elementFormChanged($(e.currentTarget)));
    }

    rowOnOffStyle(object) {
        let classTableDisableRow = this.classTableDisableRow.substr(1);
        let tr = object.parents(this.tr);
        tr.toggleClass(classTableDisableRow);
    }

    elementFormChanged(object) {
        if (object.attr('data-default') !== object.val().toString()) {
            object.addClass('pupuga-admin-table__form-element--changed');
        } else {
            object.removeClass('pupuga-admin-table__form-element--changed');
        }
    }

    filterType() {
        this.setFilterType(':not(:checked)', 'remove');
        this.setFilterType(':checked', 'add');
    }

    setFilterType(selector, action) {
        let tr = this.tr;
        this.filterObjects.not(selector).each(function() {
            let slug = $(this).data('slug');
            console.log(slug);
            let trObjects = $(tr + '--' + slug);
            switch (action) {
                case 'remove' : trObjects.removeClass('display-none');
                break;
                case 'add' : trObjects.addClass('display-none');
                break;
            }
        });
    }
}

export default Table