@props([
    'field',
    'errors' => [],
])

<div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:py-5">
    <label for="{{ $field->name }}" class="block text-xs sm:text-sm font-medium leading-5 text-gray-500 sm:text-gray-700 sm:tracking-normal tracking-wide sm:normal-case uppercase mt-6 sm:mt-px sm:py-2">
        {{ $field->getLabel() }}
    </label>

    <div class="mt-1 sm:mt-0 sm:col-span-3">
        {{ $slot }}

        @if ($errors)
            <div class="mt-1 text-red-500 text-sm">
                @foreach($errors as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if ($field->help)
            <p class="mt-2 text-sm text-gray-500">{{ $field->help }}</p>
        @endif
    </div>
</div>
