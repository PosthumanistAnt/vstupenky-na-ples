export default function patchComponent(component: any) {
    component._oldInitializeElements = component.initializeElements;
    component.initializeElements = (...args: any[]) => {
        if (window.LivewireManagingDOM) {
            window.LivewireManagingDOM.then(() => component._oldInitializeElements(...args));
        } else {
            component._oldInitializeElements(...args);
        }
    }

    component._oldUpdateElements = component.updateElements;
    component.updateElements = (...args: any[]) => {
        if (window.LivewireManagingDOM) {
            window.LivewireManagingDOM.then(() => component._oldUpdateElements(...args));
        } else {
            component._oldUpdateElements(...args);
        }
    }

    // This might eventually need the transition logic changes too, but right now we don't need them in Lean
}

window.Alpine.onBeforeComponentInitialized(patchComponent);
