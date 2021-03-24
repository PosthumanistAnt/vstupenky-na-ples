type CollectionItems<T> = { [key: string]: T }

export class Collection<T>
{
    constructor(
        public items: CollectionItems<T>,
    ) {}

    public where(key: string, value: any): Collection<T> {
        return new Collection(this.reduce((carry, v, k) => {
            let path = key.split('.').reduce((tree: any, item) => tree[item] || {}, v);

            if (path == value) {
                carry[k] = v;
            }

            return carry;
        }, {}));
    }

    public filter(callback: (item: T) => boolean): Collection<T> {
        return new Collection(this.reduce((carry, value, key) => {
            if (callback(value)) {
                carry[key] = value;
            }

            return carry;
        }, {}));
    }

    public map<U>(callback: (item: T) => U): Collection<U> {
        return new Collection(this.reduce((carry, value, key) => {
            carry[key] = callback(value);

            return carry;
        }, {}));
    }

    public each(callback: (item: T) => void): Collection<T> {
        this.values().forEach(callback);

        return this;
    }

    public forEach = this.each;

    public first(condition: (item: T) => boolean = null): T|null {
        let items: CollectionItems<T>;

        if (condition) {
            items = this.filter(condition).items;
        } else {
            items = this.items;
        }

        return Object.values(items)[0] || null;
    }

    public has(key: string): boolean {
        return key in this.items;
    }

    public contains(value: T): boolean {
        return this.values().includes(value);
    }

    public includes(value: T): boolean {
        return this.values().includes(value);
    }

    public reduce<U>(callable: (carry: U, value: T, key: string) => U, initial: U): U {
        return Object.entries(this.items).reduce((carry, [key, value]) => {
            return callable(carry, value, key);
        }, initial);
    }

    public get(key: string): T {
        return key.split('.').reduce((items: any, item) => items[item] || {}, this.items);
    }

    public count(): number {
        return Object.values(this.items).length;
    }

    public merge(items: CollectionItems<T>): Collection<T> {
        Object.assign(this.items, items);

        return this;
    }

    public keys(): string[] {
        return Object.keys(this.items);
    }

    public values(): T[] {
        return Object.values(this.items);
    }

    public toArray = this.values;

    public entries(): [string, T][] {
        return Object.entries(this.items);
    }
}
