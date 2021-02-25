/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// require('bootstrap');
require('@popperjs/core');
require('Hinclude/hinclude');

const $ = require('jquery');
global.$ = $;
// require('popper.js');

const routes = require('../public/js/fos_js_routes.json');
import Routing from '../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);
global.Routing = Routing;

// any CSS you import will output into a single css file (app.css in this case)
import './css/app.scss';

import '/vendor/adminkit/adminkit/static/js/app';

console.log('app.js');

// start the Stimulus application
import './bootstrap';

import {DataTable} from "simple-datatables"

document.querySelectorAll(".js-datatable").forEach(table => { console.log(table); });

document.querySelectorAll(".js-datatable").forEach(table => { new DataTable(table); console.log("Init DataTable " + table.id); })

