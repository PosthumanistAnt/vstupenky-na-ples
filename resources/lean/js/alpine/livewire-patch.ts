import { AlpineComponent } from '@leanadmin/alpine-typescript';

window.LivewireManagedAlpineComponents = [];

// This changes Livewire runtime to support Alpine better
document.addEventListener('livewire:load', () => {
    // Delete refreshAlpineAfterEveryLivewireRequest hook
    window.Alpine.onComponentInitializeds = [];

    // Use a custom hook to replace that
    window.Alpine.onComponentInitialized((component: AlpineComponent) => {
        let livewireEl = component.$el.closest('[wire\\:id]');

        if (livewireEl && livewireEl.__livewire) {
            window.LivewireManagedAlpineComponents.push(component);
        }
    })
})

Livewire.hook('message.sent', () => {
    window.LivewireManagingDOM = new Promise((resolve, reject) => {
        Livewire.hook('message.processed', () => {
            window.LivewireManagingDOM = false;

            resolve(true);
        });

        Livewire.hook('message.failed', () => {
            window.LivewireManagingDOM = false;

            reject();
        });
    }).then(() => {
        window.skipAlpineTransitions = true;
        window.LivewireManagedAlpineComponents.forEach(component => {
            component.updateElements(component.$el);
        });
        window.skipAlpineTransitions = false;
    }).catch(error => {
        window.LivewireManagingDOM = false;
        window.skipAlpineTransitions = false;

        console.error(error);
    });
});
