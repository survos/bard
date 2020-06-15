const $ = require('jquery');
global.$ = $;
require('popper.js');

const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);
global.Routing = Routing;

// adminlte utilities, like PushMenu.  This comes from yarn add admin-lte
require('admin-lte'); // from yarn add admin-lte, 57k, does not include bootstrap
require('bootstrap');

require('../css/app.scss');
//  require('admin-lte/dist/js/adminlte');
// require('../css/sticky-footer.css');

// const $ = global.$;
$('button:contains(Save)').addClass('btn-primary');
$('button:contains(Update)').addClass('btn-primary');

// eslint-disable-next-line new-cap
$('.js-toggle-sidebar').PushMenu({});

// this is from adminlte bundle??, we want the one from adminlte directly

// any CSS you require will output into a single css file (app.css in this case)


const x = true;

require('datatables.net-bs4');
require('datatables.net-scroller-bs4');
require('datatables.net-buttons-bs4');
require('datatables.net-select-bs4');

if (x) {
    const dataTableElements = $('.js-datatable');
    console.log('init table-datatable: ' + dataTableElements.length);
    console.log(dataTableElements);

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
