import { Action } from './action';

export class Resource {
    constructor(
        public name: string,
        public actions: Action[] = [],
    ) {}

    public trans(name: string, data: any = {}): string|null {
        return Lean.trans('resources.' + this.name, name, data);
    }

    lang = this.trans;

    public route(name: string, args: { [key: string]: string | number } = {}): string {
        return Lean.route(name, { resource: this.name, ...args });
    }
}
