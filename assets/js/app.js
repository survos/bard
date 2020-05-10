// any CSS you require will output into a single css file (app.css in this case)

require('../css/app.css');
require('datatables.net-bs4');

const $ = require('jquery');
// const $ = global.$;
$('.table-DataTable').DataTable({
    scroller: true,
    scrollY: '50vh',
    scrollX: true,
    autoWidth: true,
    dom: 'fti',
});

/**
\u0040fortawesome\/fontawesome\u002Dfree
bootstrap
fontawesome
jquery
popper.js
**/
