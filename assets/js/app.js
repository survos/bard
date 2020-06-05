// any CSS you require will output into a single css file (app.css in this case)

require('admin-lte/dist/js/adminlte');
require('../css/app.scss');

const $ = require('jquery');
require('bootstrap');

require('popper.js');

// any CSS you require will output into a single css file (app.css in this case)




// const $ = require('jquery');
// const $ = global.$;
// const survosDataTableElements = $('.survos-datatable');

const x = true;
if (x) {
    require('datatables.net-bs4');
    require('datatables.net-scroller-bs4');
    require('datatables.net-buttons-bs4');
    require('datatables.net-select-bs4');

    const dataTableElements = $('.js-datatable');
    console.log('init table-datatable: ' + dataTableElements.length);
    dump(dataTableElements);
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

}

