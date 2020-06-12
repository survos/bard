const $ = global.$;

require('datatables.net-bs4');
require('datatables.net-scroller-bs4');
require('datatables.net-buttons-bs4');
require('datatables.net-select-bs4');

// import SurvosDataTable from './Components/SurvosDataTable';
// const $ = require('jquery');
// const $ = global.$;
import SurvosDataTable from '../../vendor/survos/base-bundle/src/Resources/public/js/SurvosDataTable';

const Routing = global.Routing;

const columns = [
    {title: 'ID', data: '@id'},
    {
        title: 'Name',
        data: 'name',
        render: (data, type, row) => {
            console.warn(data);
            const url = Routing.generate('character_show', {characterId: row.id});
            return `<a href='${url}'>${data}</a>`;
        },
    },
    {title: 'Description', data: 'description'},
];

const $table = $('#character_table');
const ct = new SurvosDataTable($table, columns);
// ct.initFooter(); // add the search filters, pass params here from columns?
ct.render();

