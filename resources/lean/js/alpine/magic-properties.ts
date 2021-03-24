import { Action, SingleModelAction, WriteAction } from "../lean/action";

const actionTypes = ['index', 'create', 'show', 'edit'];

export default {
    'page': () => Lean.page,

    'resource': (componentEl: Element) => {
        let leanEl: Element = componentEl.closest('[lean\\:action\\.resource]');

        if (! leanEl) {
            console.warn('Lean: Cannot reference "$resource" outside a Lean resource.');
        }

        let resource: string = leanEl.getAttribute('lean:action.resource');

        if (! (resource in Lean.resources)) {
            console.warn('Lean: Cannot find attribute for $resource call.', componentEl);

            return;
        }

        return Lean.resources.get(resource);
    },

    'action': (componentEl: Element) => {
        let leanEl: Element = componentEl.closest('[lean\\:action]');

        if (! leanEl) {
            console.warn('Lean: Cannot reference "$action" outside a Lean action.');
        }

        let actionHash: string = leanEl.getAttribute('lean:action.hash');

        if (! Lean.actions.has(actionHash)) {
            console.warn('Lean: Cannot find attribute for $action call.', componentEl);

            return;
        }

        return Lean.actions.get(actionHash);
    },

    'model': (componentEl: Element) => {
        let leanEl: Element = componentEl.closest('[lean\\:model]');

        if (! leanEl) {
            console.warn('Lean: Cannot reference "$model" outside a Lean model.', leanEl);
        }

        let modelHash: string = leanEl.getAttribute('lean:model.hash');

        if (! Lean.models.has(modelHash)) {
            console.warn('Lean: Cannot find attribute for $model call.', componentEl);

            return;
        }

        return Lean.models.get(modelHash);
    },

    ...actionTypes.reduce((properties, action) => {
        properties[action] = (componentEl: Element) => {
            let leanEl: Element = componentEl.closest(`[lean\\:action=${action}]`);

            if (! leanEl) {
                console.warn(`Lean: Cannot reference "$${action}" outside a ${action} action.`);
            }

            let actionHash: string = leanEl.getAttribute('lean:action.hash');

            if (! Lean.actions.has(actionHash)) {
                console.warn(`Lean: Cannot find attribute for $${action} call.`, componentEl);

                return;
            }

            return Lean.actions.get(actionHash);
        };

        return properties;
    }, {}),

    'single': (componentEl: Element) => {
        let leanEl: Element = componentEl.closest('[lean\\:action]');

        if (! leanEl) {
            console.warn('Lean: Cannot reference "$single" outside a Lean action.');
        }

        let action = fetchAction(leanEl, componentEl, '$single');
        if (action instanceof SingleModelAction) {
            return action;
        }

        while (leanEl = action.element.parentElement.closest('[lean\\:action]')) {
            action = fetchAction(leanEl, componentEl, '$single');

            if (action instanceof SingleModelAction) {
                return action;
            }
        }
    },

    'form': (componentEl: Element) => {
        let leanEl: Element = componentEl.closest('[lean\\:action]');

        if (! leanEl) {
            console.warn('Lean: Cannot reference "$form" outside a Lean action.');
        }

        let action = fetchAction(leanEl, componentEl, '$form');
        if (action instanceof WriteAction) {
            return action;
        }

        while (leanEl = action.element.parentElement.closest('[lean\\:action]')) {
            action = fetchAction(leanEl, componentEl, '$form');

            if (action instanceof WriteAction) {
                return action;
            }
        }
    },
};

function fetchAction(leanEl: Element, componentEl: Element, helper: string): Action {
    let actionHash: string = leanEl.getAttribute('lean:action.hash');

    if (! Lean.actions.has(actionHash)) {
        console.warn(`Lean: Cannot find attribute for ${helper} call.`, componentEl);

        return;
    }

    return Lean.actions.get(actionHash);
}
