import { Controller } from 'stimulus';

export default class extends Controller {

static targets = ["messages"];
static values = {
    initialMessage: String,
}

    connect() {
    console.log(this.context.module.identifier);
    console.log(this.toLocaleString());
    // console.log('hello_controller');
        this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    }
}
