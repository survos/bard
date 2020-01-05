const $ = require('jquery');

require('datatables.net-bs4');
require('datatables.net-scroller-bs4');
require('datatables.net-buttons-bs4');

const routes = require('../../public/js/fos_js_routes.json');

import SurvosDataTable from '../../vendor/survos/landing-bundle/src/Resources/js/Su';


import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);


// import SurvosDataTable from "../../vendor/survos/landing-bundle/src/Resources/js/SurvosDataTable.js";
// import SurvosDataTable from "/var/www/Survos/LandingBundle/src/Resources/js/SurvosDataTable";
// const SurvosDataTable = require('');

let $workTable = $('#work-table');

let workColumns = [
    {title: 'ID', data: '@id'},
    {title: 'Title', data: 'longTitle', xfilter: 'partial'},
    {title: 'Words', data: 'totalWords', filter: {type: 'input'}},
    {title: 'Year', data: 'year', filter: {type: 'input'}},
    {title: 'Actions', data: 'id',
        render: function( data, type, row, meta ) {
            let url = Routing.generate('work_show', {id: data});
            return `<a href=${url}><i class="fas fa-scroll"></i>Show</a>`;
            console.log(data, type, row, meta);
            return "ACTION";
        }
    },
];

// trying to use external class, need to pass Routing and jQuery?? let wt = new SurvosDataTable($workTable, workColumns)(window, $, Routing);
let wt = new SurvosDataTable($workTable, workColumns, {
    search: true // in the footer?  Hmm, this is
});
wt.initFooter(); // add the search filters, pass params here from columns?
wt.render();


let columns = [
    {title: 'ID', data: '@id'},
    {title: 'Name', data: 'name'},
    {title: 'Description', data: 'description'},
];
let buttons = [

];

if (0) {
    let $table = $('#character-table');
    let ct = new SurvosDataTable($table, columns);
    ct.initFooter(); // add the search filters, pass params here from columns?
    ct.render();

}


