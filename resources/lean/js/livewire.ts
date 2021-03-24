import { Action } from "./lean/action";
import { ModelKey } from "./lean/model";
import { PendingAction } from "./helpers";
import wire_replace from '@leanadmin/wire-replace';

/**
 * This builds the data model on initial load.
 */
export const parseInitialDOM = () => {
    document.addEventListener('livewire:load', () => {
        Lean.parseDOMFragments();
    });
}

/**
 * This tells some listeners to wait until Lean finishes making changes.
 */
export const blockListeners = () => {
    Livewire.hook('message.received', () => Lean.pendingChanges = new PendingAction);
}

/**
 * This updates the data model on subsequent loads.
 */
export const parseResponses = () => {
    Livewire.hook('message.processed', () => Lean.parseDOMFragments());
}

/**
 * This registers the wire:replace directive.
 */
export const wireReplace = () => {
    Livewire.hook(...wire_replace);
}

/**
 * This checks incoming responses for any model effects.
 * If any are found, we refresh all components that
 * work with the same model, to stay up-to-date.
 */
export const observeModelChanges = () => {
    Livewire.hook('message.processed', (message: any, origin: LivewireComponent) => {
        let modelEffects: { [resource: string]: ModelKey[] } = message?.response?.serverMemo?.data?.modelEffects;

        let outdatedComponents: LivewireComponent[] = [];

        if (modelEffects) {
            Object.keys(modelEffects).forEach(resource => {
                Lean.resources.get(resource)?.actions?.forEach((action: Action) => {
                    let affectedModelsInAction = action.models.filter(model => modelEffects[resource].reduce((found: boolean, affected) => {
                        return found || model.is(affected);
                    }, false));

                    if (affectedModelsInAction.length) {
                        outdatedComponents.push(action.wire);
                    }
                })
            })
        }

        outdatedComponents.filter(component => component.id !== origin.id)
            .forEach(component => {
                component.call('$refresh');
            });
    });
}
