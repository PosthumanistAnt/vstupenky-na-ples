@php
    // Render only on the resources that manage the page, i.e. not relations
    // dd($this, Lean::$currentResource);
    if (isset($this) && isset($this->resource)) {
        if (Lean::$currentResource) {
            $shouldRender = Lean::isCurrentResource($this->resource);
        } else {
            $shouldRender = true;
        }
    } else {
        $shouldRender = true;
    }

@endphp

@if($shouldRender)
    <div class="mt-16 sm:mt-0">
        &nbsp;
    </div>

    <div class="fixed bottom-0 left-0 w-screen block sm:hidden">
        <div class="flex justify-around text-gray-600 bg-white border-t border-gray-100 shadow-2xl py-4">
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
@endif
