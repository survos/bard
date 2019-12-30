const $ = require('jquery');

require('datatables.net-bs4');
require('datatables.net-scroller-bs4');

import SurvosDataTable from "./SurvosDataTable";

const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);


// import SurvosDataTable from "./../../vendor/survos/landing-bundle/src/Resources/js/SurvosDataTable";
// const SurvosDataTable = require('');

let columns = [
    {title: 'ID', data: '@id'},
    {title: 'Name', data: 'name'},
    {title: 'Description', data: 'description'},
];

let $workTable = $('#work-table');

let workColumns = [
    {title: 'ID', data: '@id'},
    {title: 'Title', data: 'longTitle'},
    {title: 'Actions', data: 'id',
        render: function( data, type, row, meta ) {
            let url = Routing.generate('work_show', {id: data});
            return `<a href=${url}><i class="fas fa-scroll"></i>Show</a>`;
            console.log(data, type, row, meta);
            return "ACTION";
        }
    },
];

let wt = new SurvosDataTable($workTable, workColumns);
wt.render();

let $table = $('#character-table');
let ct = new SurvosDataTable($table, columns);
ct.render();


