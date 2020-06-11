const $ = global.$;
require('datatables.net-bs4');
require('datatables.net-scroller-bs4');
require('datatables.net-buttons-bs4');
require('datatables.net-select-bs4');

// import SurvosDataTable from './Components/SurvosDataTable';
// const $ = require('jquery');
// const $ = global.$;
import SurvosDataTable from '../../vendor/survos/base-bundle/src/Resources/public/js/SurvosDataTable';

const columns = [
    {title: 'ID', data: '@id'},
    {title: 'Name', data: 'name'},
    {title: 'Description', data: 'description'},
];

const $table = $('#character_table');
$table.html('testing jquery');
const ct = new SurvosDataTable($table, columns);
// ct.initFooter(); // add the search filters, pass params here from columns?
ct.render();

