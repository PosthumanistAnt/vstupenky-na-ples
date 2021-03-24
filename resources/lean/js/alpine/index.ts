import { addTitles, AlpineComponent } from '@leanadmin/alpine-typescript';
import magicProperties from './magic-properties';

// Register magic properties ($model, $action, $index, ...)
const defer: CallableFunction = window.deferLoadingAlpine;
window.deferLoadingAlpine = function (alpine: Function) {
    Object.entries(magicProperties).forEach(([property, callback]) => {
        window.Alpine.addMagicProperty(property, callback);
    });

    defer(alpine)
}

// Import and initialize Alpine
import 'alpinejs';

// Create a Promise telling Alpine to wait when Livewire is making DOM changes
import './livewire-patch';

// Make Alpine queue element updates after those Promises are resolved
import './alpine-patch';

// Add x-titles to TS components
addTitles();

// Automatically call init() if there's no x-init attribute.
window.Alpine.onBeforeComponentInitialized((component: AlpineComponent) => {
    if (! component.$el.hasAttribute('x-init') && component.$data.init) {
        component.$data.init();
    }
})
