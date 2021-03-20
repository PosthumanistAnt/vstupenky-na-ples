<nav class="mt-5 flex-1 px-2 space-y-1 text-sm font-medium">
    @foreach(($items = Lean::menuItems()) as $alias => $item)
        @if(($group = $item) instanceof Lean\Menu\MenuGroup)
            <div
                x-title="Link group {{ $group->name }}"
                x-data="{
                    expanded: @json($expanded = $group->expanded || $group->children->map(fn ($group) => $group->active)->contains(true) )
                }"
                class="pt-2 mr-2"
            >
                <x-lean::navigation.group :name="$group->name" :expanded="$expanded" />
                <div x-ref="items" x-show="expanded" @if(! $expanded) x-cloak @endif class="pl-4 space-y-1 mt-2">
                    @foreach($group->children as $child)
                        <x-lean::navigation.item :item="$child" />
                    @endforeach
                </div>
            </div>
        @else
            <x-lean::navigation.item :item="$item" />
        @endif
    @endforeach
</nav>
