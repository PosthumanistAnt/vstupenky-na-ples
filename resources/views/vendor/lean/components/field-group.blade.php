@props([
    'field',
    'errors' => [],
])

<div class="flex flex-col sm:items-baseline sm:flex-row sm:space-x-4 space-y-1 py-4">
    <label for="{{ $field->id($_instance) }}" class="sm:w-1/4 w-full block text-xs sm:text-sm font-medium leading-5 text-gray-500 sm:text-gray-700 dark:text-gray-200 sm:dark:text-gray-300 sm:tracking-normal tracking-wide sm:normal-case uppercase sm:py-2">
        {{ $field->getLabel() }}
    </label>

    <div class="mt-1 sm:mt-0 sm:w-3/4 w-full">
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
