import { AlpineComponent } from "@leanadmin/alpine-typescript"
import { PendingAction } from "../helpers";
import { Action } from "../lean/action";

interface LivewireModalManager extends LivewireComponent {
    loadModal(name: string, data: object): Promise<any>;
}

export type ModalHooks = { [key in 'action' | 'result']: Promise<Action> | null };

export type ModalPayload = {
    name: string;
    fullWidth?: boolean;
    backendData: {
        _modalID?: string;
        _modalAction?: string;
        [key: string]: any;
    };
    frontendData: any;
}

export type CurrentModal = {
    current?: ModalPayload|null,
    show?: boolean,
}

/**
 * Fired when we're updating *what* modal is displayed.
 */
export class ModalChange extends CustomEvent<CurrentModal> {
    public static dispatch(detail: CurrentModal) {
        window.dispatchEvent(new ModalChange('modal-change', { detail }));
    }
}

/**
 * Fired when we're updating the *data* of a specific modal.
 */
export class ModalStateUpdate extends CustomEvent<ModalPayload> {
    public static dispatch(detail: ModalPayload) {
        window.dispatchEvent(new ModalStateUpdate('modal-state-update', { detail }));
    }
}

export default class ModalManager extends AlpineComponent {
    public $wire?: LivewireModalManager;
    public readyModals: any = {};

    public showing: boolean = false;
    public current: ModalPayload|null;

    public history: ModalPayload[] = [];

    private promisedAction: PendingAction<Action>|null = null;
    private promisedResult: PendingAction<Action>|null = null;

    public show(payload: ModalPayload): ModalHooks {
        this.showing = true;

        let id = this.find(payload);
        if (id) {
            payload.backendData._modalID = id;

            // Update the modal's frontend state
            ModalStateUpdate.dispatch(payload);

            // Make this modal the currently shown modal
            this.current = payload;
        } else {
            this.current = null;

            this.fetch(payload);
        }

        if (! this.current) {
            this.promisedAction = new PendingAction<Action>();
            this.promisedResult = new PendingAction<Action>();
        }

        // todo maybe rename these to 'opened' and 'closed'?
        // and maybe another state for "confirmed" rather than just closed
        return {
            action: this.promisedAction?.promise,
            result: this.promisedResult?.promise,
        };
    }

    protected find({ name, backendData }: ModalPayload): string|false {
        if (backendData._modalID in this.readyModals) {
            return backendData._modalID;
        }

        for (let modal of Object.values(this.readyModals)) {
            let readyModal = {};
            Object.assign(readyModal, modal);

            let id = readyModal['_modalID'];
            delete readyModal['_modalID'];

            readyModal = JSON.stringify(readyModal, Object.keys(readyModal).sort());

            // Livewire converts empty objects to empty arrays
            if (readyModal === '[]') {
                readyModal = '{}';
            }

            let requestedModal = { _modalAction: name, ...backendData };

            if (readyModal === JSON.stringify(requestedModal, Object.keys(requestedModal).sort())) {
                return id;
            }
        };

        return false;
    }

    public hide() {
        this.history = [];
        this.showing = false;

        if (this.current) {
            let action = document
                .querySelector(`[wire\\:key=modal\\-${this.current.backendData._modalID}]`)
                ?.querySelector('[lean\\:action]')
                ?.getAttribute('lean:action.hash');

            if (action) {
                this.promisedResult.resolve(Lean.actions.get(action));
            }
        }

        this.current = null;

        this.promisedAction?.reject();
        this.promisedAction = null;

        this.promisedResult?.reject();
        this.promisedResult = null;
    }

    public fetch(payload: ModalPayload) {
        const { name, backendData } = payload;

        this.$wire
            .loadModal(name, backendData)
            .then(() => {
                this.readyModals = this.$wire.get('readyModals');

                this.show(payload);
            });
    }

    public back(): void {
        if (this.history.length < 2) {
            this.hide();

            return;
        }

        let current = this.history.pop();
        let previous = this.history.pop();

        this.show(previous);
    }

    public changeCurrentModal({ current = this.current, show = this.showing }: CurrentModal = {}) {
        if (current) {
            let action = document
                .querySelector(`[wire\\:key=modal\\-${current.backendData._modalID}]`)
                ?.querySelector('[lean\\:action]')
                ?.getAttribute('lean:action.hash');

            if (action) {
                this.promisedAction.resolve(Lean.actions.get(action));
            }
        }

        ModalChange.dispatch({ current, show });
    }

    public init(): void {
        Lean.modalManager = this;

        this.readyModals = this.$wire.get('readyModals');

        this.$el.addEventListener('modal-closed', () => {
            this.hide();
        });

        this.$watch('showing', show => {
            this.changeCurrentModal({ show });
        });

        this.$watch('current', (current: ModalPayload|null) => {
            this.changeCurrentModal({ current });

            if (current) {
                this.history.push(current);
            }
        });
    }
}
