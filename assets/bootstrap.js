import { startStimulusApp } from '@symfony/stimulus-bridge';
<<<<<<< HEAD
import '@symfony/autoimport';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context('./controllers', true, /\.(j|t)sx?$/));
=======

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.(j|t)sx?$/
));
>>>>>>> 06614677b5a1f78fd0a20c1848fef2d9684ed8e0
