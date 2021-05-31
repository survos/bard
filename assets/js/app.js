const $ = require('jquery');
global.$ = $;

const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);
global.Routing = Routing;

require('@adminkit/core/static/js/app');
require('@popperjs/core');
require('bootstrap');
require('Hinclude/hinclude');

require('../css/app.scss');
//  require('admin-lte/dist/js/adminlte');
// require('../css/sticky-footer.css');

// const $ = global.$;
$('button:contains(Save)').addClass('btn-primary');
$('button:contains(Update)').addClass('btn-primary');

// eslint-disable-next-line new-cap
// $('.js-toggle-sidebar').PushMenu({});

// this is from adminlte bundle??, we want the one from adminlte directly

// any CSS you require will output into a single css file (app.css in this case)


const x = true;

require('datatables.net-bs4');
require('datatables.net-scroller-bs4');
require('datatables.net-buttons-bs4');
require('datatables.net-select-bs4');

if (x) {
    const dataTableElements = $('.js-datatable');
    console.log('init table-datatable: ' + dataTableElements.length);

    // basic initialation
    dataTableElements.each(function (index) {
        console.log(index, $(this));
        const options = $(this).data();
        console.log('data is ', options);

        const o = {
            dom: 'ftir',
            'scroller': true,
            'scrollX': true,
            'scrollY': '30vh',
            'autoWidth': true,
        };

        console.log('options', options);
        console.log('o', o);
        Object.assign(o, options);

        console.log('extended o', o);
        // eslint-disable-next-line new-cap
        $(this).DataTable(o);

        // console.log(index, .text());
    });

}


// import {DataTable} from "simple-datatables"
//
// document.querySelectorAll(".js-datatable").forEach(table => { console.log(table); });
//
// document.querySelectorAll(".js-datatable").forEach(table => { new DataTable(table); console.log("Init DataTable " + table.id); })
