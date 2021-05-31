// const $ = global.$;
// const $ = require('jquery');
console.log('hello, works.js');

/*
require('datatables.net-bs');
require('datatables.net-scroller-bs');
require('datatables.net-buttons-bs');
*/
const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);

// import SurvosDataTable from '../../vendor/survos/landing-bundle/src/Resources/public/js/SurvosDataTable';
// import SurvosDataTable from './Components/SurvosDataTable';
// import SurvosDataTable from '../../vendor/survos/base-bundle/src/Resources/public/js/SurvosDataTable';
import {SurvosDataTable} from 'survos-datatables';

// not sure if we use this for both ElasticSearch and for Doctrine.  Both are API platform.
const $workTable = $('#work-table');
const workColumns = [
    {title: 'ID', data: '@id'},
    {title: 'Title', data: 'longTitle', xfilter: 'partial'},
    {title: 'Words', data: 'totalWords', filter: {type: 'input'}},
    {title: 'Year', data: 'year', filter: {type: 'input'}},
    {
        title: 'Actions', data: 'id',
        render(data /* , type, row, meta */) {
            const url = Routing.generate('work_show', {id: data});
            return `<a href=${url}><i class="fas fa-scroll"></i>Show</a>`;
            // console.log(data, type, row, meta);
            // return "ACTION";
        },
    },
];

// trying to use external class, need to pass Routing and jQuery??
// let wt = new SurvosDataTable($workTable, workColumns)(window, $, Routing);
const wt = new SurvosDataTable($workTable, workColumns, {
    search: true, // in the footer?  Hmm, this is
});
wt.initFooter(); // add the search filters, pass params here from columns?
wt.render();


if (0) {
    $workTable.DataTable({
        columns: workColumns,
    });
}




