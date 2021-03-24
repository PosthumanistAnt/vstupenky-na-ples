import { Action } from './action';

export type ModelKey = string|number;

export type VisitType = 'redirect' | 'modal' | 'forceRedirect';

export class Model {
    constructor(
        public hash: string,
        public id: ModelKey,
        public key: string,
        public action: Action,
        public _attributes: { [key: string]: Attribute } = {},
    ) {}

    get attributes() {
        return new Proxy(this._attributes, {
            get(target, prop, receiver) {
                let value = Reflect.get(target, prop, receiver);
                if (value) {
                    return value.value;
                }
            },

            set(target, prop, value, receiver) {
                Reflect.get(target, prop, receiver).value = value;

                return true;
            },
        });
    }

    set attributes(values: { [key: string]: any }) {
        Object.entries(values).forEach(([key, value]) => {
            this._attributes[key].value = value;
        });
    }

    public is(key: ModelKey) {
        return this.id.toString() === key.toString();
    }

    public edit(view: VisitType = 'redirect') {
        const redirect = (force = false) => Lean.redirect(this.action.resource.route('edit', { model: this.id }), force);

        if (view === 'modal') {
            Lean.modal('edit', { resource: this.action.resource, model: this });
        } else {
            redirect(view === 'forceRedirect');
        }
    }

    public show(view: VisitType = 'redirect') {
        const redirect = (force = false) => Lean.redirect(this.action.resource.route('show', { model: this.id }), force);

        if (view === 'modal') {
            Lean.modal('show', { resource: this.action.resource, model: this });
        } else {
            redirect(view === 'forceRedirect');
        }
    }

    public delete() {
        Lean.modal('delete', {}, {
            resource: this.action.resource.name,
            model: this.id,
        }, { fullWidth: false });
    }
}

export class Attribute {
    constructor(
        public key: string,
        public model: Model,
        public proxy: boolean = true,

        /** Used when we don't have a LW proxy available. */
        public _value: any = null,
    ) {}

    get value(): any {
        if (this.proxy) {
            return this.model.action.wire.get(`fieldMetadata.${this.key}.value`);
        } else {
            return this._value;
        }
    }

    set value(value: any) {
        if (this.proxy) {
            this.model.action.wire.set(`fieldMetadata.${this.key}.value`, value);
        } else {
            this._value = value;
        }
    }

    defer(value: any) {
        if (this.proxy) {
            this.model.action.wire.set(`fieldMetadata.${this.key}.value`, value, true);
        } else {
            console.error('Lean: No wire proxy is available for attribute', this);
        }
    }
}
