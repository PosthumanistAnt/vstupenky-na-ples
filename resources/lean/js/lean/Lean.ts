import ModalManager, { ModalHooks } from '../components/modalManager';
import { PendingAction } from '../helpers';
import { Action, ActionType } from './action';
import { Attribute, Model } from './model';
import { Resource } from './resource';
import { Collection } from './collection';

// todo action should also have fields aside from models
// and it'd be nice if we could prevent closing modals when they're transmitting data to the server

interface State {
    app: string;
    page: string;
    title: string;

    currentResource: string|null;
    currentPage: string|null;
    currentAction: string|null;
    currentActionType: ActionType|null;
}

type ModalConfig = { [fullWidth: string]: boolean };

export class Lean {
    version: string;
    environment: string;

    state: State;

    forceRedirect: boolean = false;
    pendingChanges: PendingAction|null = null;

    routes: { [name: string]: string };
    lang: any;

    resources: Collection<Resource>;
    actions: Collection<Action>;
    models: Collection<Model>;

    public modalManager: ModalManager;

    get action(): Action|null {
        if (this.state.currentAction) {
            return this.actions.filter(action => action.hash === this.state.currentAction).first() || null;
        }

        return null;
    }

    get resource(): Resource|null {
        return this.resources.get(this.state.currentResource) || null;
    }

    get page(): Action|null {
        if (! this.state.currentPage) {
            return null;
        }

        return this.actions.filter(action => action.name === this.state.currentPage).first() || null;
    }

    public parseDOMFragments()
    {
        this.resources = new Collection<Resource>({});
        this.actions = new Collection<Action>({});
        this.models = new Collection<Model>({});

        document.querySelectorAll('[lean\\:action]')
            .forEach(element => {
                let resource: Resource|null;

                if (element.hasAttribute('lean:action.resource')) {
                    let resourceName: string = element.getAttribute('lean:action.resource');

                    if (! this.resources.has(resourceName)) {
                        this.resources.items[resourceName] = new Resource(resourceName);
                    }

                    resource = this.resources.get(resourceName);
                }

                let hash: string = element.getAttribute('lean:action.hash');
                let name: string = element.getAttribute('lean:action');
                let type: ActionType = element.getAttribute('lean:action.type') as ActionType;

                let action: Action = new Action(hash, name, type, resource);

                this.actions.items[hash] = action;

                if (resource) {
                    resource.actions[hash] = action;
                }
            })

        document.querySelectorAll('[lean\\:model]')
            .forEach(element => {
                let actionEl: Element|null = element.closest('[lean\\:action]');

                if (! actionEl) {
                    if (element.hasAttribute('lean:action')) {
                        actionEl = element;
                    } else {
                        console.error('Lean: Model without action element.', element);

                        return;
                    }
                }

                let actionHash: string = actionEl.getAttribute('lean:action.hash');

                if (! this.actions.has(actionHash)) {
                    console.error('Lean: Model without registered action.', element);

                    return;
                }

                let action: Action = this.actions.get(actionHash);

                let hash: string = element.getAttribute('lean:model.hash');
                let id: string = element.getAttribute('lean:model');
                let key: string = element.getAttribute('lean:model.key');

                let model: Model = this.models.items[hash] = new Model(hash, id, key, action);
                let fieldMetadata = model.action.wire.get('fieldMetadata');

                if (typeof fieldMetadata !== 'undefined') {
                    model._attributes = Object.entries(fieldMetadata).reduce((result, [attribute]) => {
                        return { [attribute]: new Attribute(attribute, model), ...result };
                    }, {});
                } else {
                    if (! element.hasAttribute('lean:model.attributes')) {
                        console.error('Lean: Model without attributes or fieldMetadata', element);

                        return;
                    }

                    model._attributes = Object.entries(
                        JSON.parse(element.getAttribute('lean:model.attributes'))
                    ).reduce((result, [attribute, value]) => {
                        return { [attribute]: new Attribute(attribute, model, false, value), ...result };
                    }, {});
                }


                action.models.push(model);
            });

        if (this.pendingChanges) {
            this.pendingChanges.resolve(true);
            this.pendingChanges = null;
        }
    }

    public trans(group: string, name: string, data: any = {}): string|null {
        let lang = group.split('.').reduce((lang, group) => lang[group], this.lang)[name];

        if (! lang) {
            return null;
        }

        Object.entries(data).forEach(([value, arg]) => {
            lang = lang.replace(':' + arg, value);
        });

        return lang;
    }

    public route(name: string, args: { [key: string]: string|number } = {}): string {
        let route = this.routes[name];

        Object.entries(args).forEach(([arg, value]) => {
            route = route.replace('$' + arg + '$', value.toString());
        });

        return route;
    }

    public modal(name: string, backendData: any = {}, frontendData: any = {}, config: ModalConfig = { fullWidth: true }): ModalHooks {
        if (backendData instanceof Model) {
            const model = backendData;

            backendData = {
                resource: model.action.resource.name,
                model: model.id,
            };
        }

        if (typeof backendData === 'string') {
            backendData = {
                resource: backendData,
            };
        }

        if (typeof backendData === 'object') {
            if (backendData.model instanceof Model) {
                backendData.model = backendData.model.id;
            }

            if (backendData.resource instanceof Resource) {
                backendData.resource = backendData.resource.name;
            }
        }

        return this.modalManager.show({ name, backendData, frontendData, fullWidth: config['fullWidth'] });
    }

    public back(): void {
        window.history.back();
    }

    public redirect(url: string, force: boolean = false): void {
        this.forceRedirect = force;

        if (Turbolinks && Turbolinks.supported) {
            Turbolinks.visit(url);
        } else {
            window.location.href = url;
        }

        // This is also set elsewhere, but won't hurt here
        this.forceRedirect = false;
    }

    public isMobile(): boolean {
        return (('ontouchstart' in window) ||
            (navigator.maxTouchPoints > 0) ||
            (navigator.msMaxTouchPoints > 0));
    }
}
