const $ = require('jquery');
import {SurvosDataTable} from 'survos-datatables';

const Routing = global.Routing;
console.log(Routing);

const columns = [
    {title: 'ID', data: '@id'},
    {
        title: 'Name',
        data: 'name',
        render: (data, type, row) => {
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

