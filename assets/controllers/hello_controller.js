import {Controller} from 'stimulus';

export default class extends Controller {

    static targets = ['messages'];
    static values = {
        initialMessage: String,
    };

    connect() {

        var html = 'nada';
        var twig = require('twig').twig;
        html = twig({
            id: "your-custom-template-id",
            data: '<p>your template here</p>',
            allowInlineIncludes: true,
            rethrow: true
        });
        console.log(html);

        const template = require('../templates/x.html.twig');
        console.log(template);
        html = template({title: 'dialog title'});


        // var template = require("work.html.twig");
        // console.log(template);
        // html = template({title: 'dialog title'});
        //
        // console.log('connecting controller ' + this.context.module.identifier);
        // console.log(this);
        // console.log('hello_controller');
        this.messagesTarget.innerHTML = html;
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    }
}
