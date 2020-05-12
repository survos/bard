// any CSS you require will output into a single css file (app.css in this case)

require('../css/app.css');
require('datatables.net-bs4');
require('datatables.net-scroller-bs4');

// const $ = require('jquery');
// const $ = global.$;
const dataTableElements = $('.table-datatable');
const survosDataTableElements = $('.survos-datatable');


console.log('init table-datatable: ' + dataTableElements.length);

// basic initialation
dataTableElements.each(function (index) {
    const options = $(this).data();
    console.log(options);

    let o = {
        dom: 'ft',
        scroller: true,
        scrollX: true,
        scrollY: '100vh',
        autoWidth: true,
    };

    $.extend(o, options);

    console.log(o);
    // eslint-disable-next-line new-cap
    $(this).DataTable(o);

    // console.log(index, .text());
});

