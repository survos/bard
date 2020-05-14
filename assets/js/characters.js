import SurvosDataTable from "./Components/SurvosDataTable";

const columns = [
    {title: 'ID', data: '@id'},
    {title: 'Name', data: 'name'},
    {title: 'Description', data: 'description'},
];

const $table = $('#character_table');
const ct = new SurvosDataTable($table, columns);
// ct.initFooter(); // add the search filters, pass params here from columns?
ct.render();

if (0) {
}

