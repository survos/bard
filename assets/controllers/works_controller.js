// import {Controller} from "@hotwired/stimulus"
// import {SurvosDataTable} from 'survos-datatables';
import DatatableController from './datatable_controller';

const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);


// https://mikerogers.io/2020/06/07/how-to-interpolate-templates-in-stimulus
//
export default class extends DatatableController {

    // static targets = ["table", 'htmlTable', "option", "branch", "commits", "resourceTemplate", "messages", "debug"];
    //
    // static values = {
    //     apiCall: {type: String, default: 'apiCall'},
    // }

    // connect() {
    //     console.log("Connecting to works_controller, will call " + this.apiCallValue);
    //     if (this.hasTableTarget) {
    //         this.initDatatable(this.tableTarget);
    //     }
    // }

    // connect() {
    //     super.connect();
    // }

    columns() {
        const columns = [];
        columns.push({data: 'id'});
        columns.push({data: 'title'});
        columns.push({title: 'marking', data: 'marking'});
        columns.push({data: 'year'});
        return columns;
    }
}

// function truncate (v) {
//     var newline = v.indexOf('\n')
//     return newline > 0 ? v.slice(0, newline) : v
// }

