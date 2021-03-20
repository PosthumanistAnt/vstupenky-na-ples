<div class="w-full text-gray-700 dark:text-gray-300 font-medium text-2xl flex items-center justify-center space-x-2">
    @if($logo = Lean::config('graphics.logo'))
        <img src="{{ url()->isValidUrl($logo) ? $logo : Lean::graphic($logo, ['w' => 50, 'h' => 50]) }}" class="max-h-10">
    @endif

    <div>
        {{ Lean::name() }}
    </div>
</div>
