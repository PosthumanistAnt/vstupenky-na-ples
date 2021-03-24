import { AlpineComponent } from '@leanadmin/alpine-typescript';

export default class BackButton extends AlpineComponent {
    public init() {
        this.$el.addEventListener('click', (event: MouseEvent) => {
            if (this.inModal()) {
                Lean.modalManager.back();

                event.preventDefault();

                return;
            } else {
                Lean.back();

                event.preventDefault();

                return;
            }
        })
    }

    protected inModal(): boolean {
        return !! this.$el.closest('#modal-manager');
    }
}
