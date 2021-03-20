<div
    id="modal-manager"
    x-data="Alpine.component('modalManager')()"
    wire:ignore.self
>
    <x-lean::modal>
        <x-slot name="trigger">
            <div @modal-change.window="
                show = $event.detail.show;

                if ($event.detail.current) {
                    data.current = $event.detail.current.backendData._modalID;
                    fullWidth = $event.detail.current.fullWidth;
                } else if (show) {
                    data.current = null;
                    fullWidth = true;
                }
            "></div>
        </x-slot>

        <div x-show="show && ! data.current" class="w-full flex justify-center items-center h-80">
            <x-lean::spinner />
        </div>

        @foreach($readyModals as $id => $modal)
            <div
                wire:key="modal-{{ $id }}"
                x-show="data.current === '{{ $id }}'"
            >
                <x-lean::action
                    :action="$modal['_modalAction']"
                    :data="$this->dataForModal($id)"
                    :refresh="true"
                    :parent="$this"
                />
            </div>
        @endforeach
    </x-lean::modal>
</div>
