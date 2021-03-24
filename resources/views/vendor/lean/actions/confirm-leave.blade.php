<div x-data="Alpine.component('modalAction')('confirm-leave', {
    stay: null,
    leave: null,

    lang(string) {
        return Lean.trans('actions.confirm-leave', string)
    },

    cancel() {
        this.stay();

        Lean.modalManager.back();
    },

    confirm() {
        this.leave();

        Lean.modalManager.back();
    },
})" class="sm:flex sm:items-start" wire:ignore.self>
    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
        @svg('heroicon-o-exclamation', ['class' => 'h-6 w-6 text-red-600'])
    </div>

    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
        <h3 class="text-lg font-medium" x-text="lang('title')"></h3>

        <div class="mt-3">
            <span x-text="lang('body')"></span>

            <div class="mt-4 flex flex-col sm:flex-row justify-end gap-2">
                <x-lean::button class="text-center block" design="secondary" x-on:click="cancel()" x-text="lang('cancel')" />
                <x-lean::button class="text-center block" design="danger" x-on:click="confirm()" x-text="lang('confirm')" />
            </div>
        </div>
    </div>
</div>
