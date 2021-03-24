import { Model, ModelKey } from './model';
import { Resource } from './resource';

// todo: more actions, like 'write'. plus handling below
export type ActionType = 'index' | 'create' | 'show' | 'edit';

export class Action {
    constructor(
        public hash: string,
        public name: string,
        public type: ActionType,
        public resource?: Resource,
        public models: Model[] = [],
    ) {
        if (type === 'index' && ! (this instanceof IndexAction)) {
            return new IndexAction(hash, name, type, resource, models);
        }

        if (type === 'edit' && ! (this instanceof WriteAction)) {
            return new WriteAction(hash, name, type, resource, models);
        }

        if (type === 'create' && ! (this instanceof WriteAction)) {
            return new WriteAction(hash, name, type, resource, models);
        }

        if (type === 'show' && ! (this instanceof SingleModelAction)) { // todo not necessarily
            return new SingleModelAction(hash, name, type, resource, models);
        }
    }

    get element(): Element {
        let elements = Array.from(document.querySelectorAll('[lean\\:action]'))
            .filter(element => {
                return element.getAttribute('lean:action.hash') === this.hash;
            });

        if (! elements.length) {
            console.error("Lean: Can't find element for action.", this);

            return;
        }

        return elements[0];
    }

    get wire(): LivewireComponent {
        return Livewire.components.findComponent(this.hash);
    }
}

export class IndexAction extends Action
{
    get page(): number {
        return this.wire.get('page');
    }

    set page(page: number) {
        this.wire.set('page', page);
    }

    get search(): string {
        return this.wire.get('search');
    }

    set search(search: string) {
        this.wire.set('search', search);
    }

    public deleteSelected(): void {
        this.wire.call('deleteSelected');
    }

    get filters(): object {
        return this.wire.get('filterMetadata');
    }

    set filters(filters: object) {
        this.wire.set('filterMetadata', filters);
    }

    get selected(): Array<Model|ModelKey> {
        let selected: ModelKey[]|{ [key: string]: ModelKey } = this.wire.get('selected') || [];

        return Object.values(selected).map(id => this.find(id));
    }

    set selected(selection: Array<Model|ModelKey>) {
        this.wire.call('replaceSelection', selection);
    }

    public select(models: Array<Model|ModelKey>) {
        this.wire.call('mergeSelection', models);
    }

    public find(id: ModelKey): Model|null {
        return this.models.filter(model => model.is(id))[0] ?? null;
    }
}

export class SingleModelAction extends Action {
    get model(): Model {
        if (! this.models.length) {
            console.error('Lean: Could not find a model for action.', this);

            return;
        }

        return this.models[0];
    }
}

export class WriteAction extends SingleModelAction {
    get dirty(): boolean {
        return this.wire.get('dirty');
    }

    set dirty(dirty: boolean) {
        this.wire.set('dirty', dirty);
    }

    public confirmedLeave: boolean = false;
    public confirmLeave(): Promise<boolean> {
        return new Promise(resolve => {
            Lean.modal('confirm-leave', {}, {
                model: this.model,
                stay: () => resolve(this.confirmedLeave = false),
                leave: () => resolve(this.confirmedLeave = true),
            }, { fullWidth: false });
        });
    }

    public submit() {
        this.wire.call('submit');
    }
}
