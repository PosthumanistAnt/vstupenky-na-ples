<nav class="mt-5 flex-1 px-2 space-y-1 text-sm font-medium">
    @foreach(Lean::pages() as $alias => $page)
        <a href="{{ route('lean.page', ['page' => $alias]) }}"
            @if(Lean::isCurrentPage($alias))
                class="border-purple-600 flex items-center pl-3 py-2 bg-purple-50 text-purple-600 group border-l-4"
            @else
                class="border-transparent flex items-center pl-3 py-2 text-gray-600 hover:text-purple-900 group border-l-4"
            @endif
        >
            @svg($page::icon(), ['class' => 'mr-4 h-6 w-6 text-purple-400 group-hover:text-purple-600 transition ease-in-out duration-150'])

            {{ $page::label() }}
        </a>
    @endforeach

    @foreach(Lean::resources() as $alias => $resource)
        <a href="{{ route('lean.resource.index', ['resource' => $alias]) }}"
            @if($resource::isActive())
                class="border-purple-600 flex items-center pl-3 py-2 bg-purple-50 text-purple-600 group border-l-4"
            @else
                class="border-transparent flex items-center pl-3 py-2 text-gray-600 hover:text-purple-900 group border-l-4"
            @endif
        >
            @svg($resource::icon(), ['class' => 'mr-4 h-6 w-6 text-purple-400 group-hover:text-purple-600 transition ease-in-out duration-150'])

            {{ $resource::pluralLabel() }}
        </a>
    @endforeach
</nav>
