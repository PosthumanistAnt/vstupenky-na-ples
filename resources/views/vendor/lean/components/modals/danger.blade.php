@props([
    'action',
])

<div x-data="Alpine.component('modalAction')('{{ $action }}', {
    {{ $data }}
})" x-init="init" class="sm:flex sm:items-start" wire:ignore.self>
    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
        @svg('heroicon-o-exclamation', ['class' => 'h-6 w-6 text-red-600'])
    </div>

    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
        {{ $title }}

        <div class="mt-3">
            {{ $body }}

            <div class="mt-4 flex flex-col sm:flex-row justify-end gap-2">
                {{ $buttons }}
            </div>
        </div>
    </div>
</div>
