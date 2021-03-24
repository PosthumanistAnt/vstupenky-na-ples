@php
    // When there are multiple resources on a page, render the menu only on the
    // resource that manages the page, not other resources such as relations.
    $component = (isset($this) ? $this : $_instance) ?? null;

    if ($component && Lean::$currentAction) {
        $shouldRender = Lean::isCurrentAction($component) && Lean::$fullPageVisit;
    } else {
        $shouldRender = Lean::$fullPageVisit;
    }
@endphp

@if($shouldRender)
<div class="relative w-full">
    <div class="mt-16 sm:mt-0">
        &nbsp;
    </div>

    <div class="fixed bottom-0 left-0 w-full block sm:hidden z-10">
        <div class="flex justify-around items-center text-gray-600 bg-white border-t border-gray-100 shadow-2xl py-3">
            @if(isset($left))
                {{ $left }}
            @else
                <x-lean::navigation.mobile.left />
            @endif

            @if(isset($button))
                {{ $button }}
            @endif

            @if($slot->isNotEmpty())
                {{ $slot }}
            @endif

            @if(isset($right))
                {{ $right }}
            @else
                <x-lean::navigation.mobile.right />
            @endif
        </div>
    </div>
</div>
@endif
