import { AlpineComponent } from '@leanadmin/alpine-typescript';

export default class ModalLink extends AlpineComponent {
    constructor(
        public action: string,
        public data: any,
        public forceModal: boolean = false,
    ) {
        super();
    }

    public init() {
        this.$el.addEventListener('click', (event: MouseEvent) => {
            if (this.shouldUseModal()) {
                // metaKey = cmd
                if ((event.ctrlKey || event.metaKey) && this.$el.hasAttribute('href')) {
                    return;
                }

                Lean.modal(this.action, this.data);

                event.preventDefault();
            }

            if (event.shiftKey) {
                Lean.modal(this.action, this.data);

                event.preventDefault();
            }
        });

        this.$el.addEventListener('pointerdown', (event: MouseEvent) => {
            const longHold = window.setTimeout(() => {
                if (Lean.isMobile()) {
                    Lean.modal(this.action, this.data);

                    event.preventDefault();
                    event.stopPropagation();
                    event.stopImmediatePropagation();
                }
            }, 300);

            window.addEventListener('pointerup', () => clearTimeout(longHold));
        });
    }

    protected shouldUseModal(): boolean {
        return this.forceModal || (!! this.$el.closest('#modal-manager'));
    }
}
