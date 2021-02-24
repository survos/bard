/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// require('bootstrap');
require('@popperjs/core');
require('Hinclude/hinclude');

// any CSS you import will output into a single css file (app.css in this case)
import './css/app.scss';

import '/vendor/adminkit/adminkit/static/js/app';

console.log('app.js');

// start the Stimulus application
import './bootstrap';

