export class PendingAction<T = any> {
    public readonly promise: Promise<T>;
    public resolve: (value: T) => void;
    public reject: (reason?: any) => void;

    constructor() {
        this.promise = new Promise<T>((resolve, reject) => {
            this.resolve = resolve;
            this.reject = reject;
        });
    }

    public then(...args: any): Promise<T> {
        return this.promise.then(...args);
    }

    public catch(...args: any): Promise<T> {
        return this.promise.catch(...args);
    }
}
