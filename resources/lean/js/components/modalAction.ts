import { AlpineComponent } from '@leanadmin/alpine-typescript';
import { ModalStateUpdate } from './modalManager';

export default class ModalAction extends AlpineComponent
{
    constructor(
        protected readonly _action_name: string,
        initialState: any = {},
    ) {
        super();

        Object.assign(this, initialState);
    }

    updated() {
        // Used in individual components
    }

    init() {
        window.addEventListener('modal-state-update', (event: ModalStateUpdate) => {
            if (event.detail.name === this._action_name) {
                Object.assign(this, event.detail.frontendData);

                this.updated();
            }
        });
    }
}
