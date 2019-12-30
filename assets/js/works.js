const $ = require('jquery');

require('datatables.net-bs4');
require('datatables.net-scroller-bs4');

import SurvosDataTable from "./SurvosDataTable";
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
];

let wt = new SurvosDataTable($workTable, workColumns);
wt.render();

let $table = $('#character-table');
let ct = new SurvosDataTable($table, columns);
ct.render();


