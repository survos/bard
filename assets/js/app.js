// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

require('datatables.net-bs');
require('datatables.net-scroller-bs');
require('datatables.net-buttons-bs');
require('datatables.net-select-bs');

// const $ = require('jquery');
// const $ = global.$;
const dataTableElements = $('.table-datatable');
// const survosDataTableElements = $('.survos-datatable');


console.log('init table-datatable: ' + dataTableElements.length);

// basic initialation
dataTableElements.each(function (index) {
    console.log($(this));
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

