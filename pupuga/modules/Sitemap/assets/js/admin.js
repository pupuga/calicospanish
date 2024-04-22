import Table from './table';
import Sitemap from './sitemap';

let $ = jQuery;

class Admin {
    constructor() {
        new Table({
            'filter': '.pupuga-input--checkbox-type-filter',
            'table': '.pupuga-admin-table'
        });
        new Sitemap({
            'generate': '.button--generate-map',
            'save': '.button--save-map'
        });
    }
}

document.addEventListener('DOMContentLoaded', function (){
    if ($('.pupuga-admin-page--sitemap').length > 0) {
        new Admin();
    }
});