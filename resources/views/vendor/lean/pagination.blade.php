<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            <div class="flex justify-between flex-1 sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-200 bg-white dark:bg-gray-600 border border-gray-300 dark:border-0 dark:border-gray-700 cursor-default leading-5 rounded-md">
                            {!! gloss('lean::resources.index.pagination.previous') !!}
                        </span>
                    @else
                        <button wire:click="previousPage" wire:loading.attr="disabled" dusk="previousPage.before" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-400 bg-white dark:bg-gray-600 border border-gray-300 dark:border-0 dark:border-gray-700 leading-5 rounded-md hover:text-gray-500 dark:hover:text-gray-50 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            {!! gloss('lean::resources.index.pagination.previous') !!}
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage" wire:loading.attr="disabled" dusk="nextPage.before" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 dark:text-gray-400 bg-white dark:bg-gray-600 border border-gray-300 dark:border-0 dark:border-gray-700 leading-5 rounded-md hover:text-gray-500 dark:hover:text-gray-50 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            {!! gloss('lean::resources.index.pagination.next') !!}
                        </button>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 dark:text-gray-200 bg-white dark:bg-gray-600 border border-gray-300 dark:border-0 dark:border-gray-700 cursor-default leading-5 rounded-md">
                            {!! gloss('lean::resources.index.pagination.next') !!}
                        </span>
                    @endif
                </span>
            </div>

            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-400 leading-5" wire:replace>
                        {!! gloss('lean::resources.index.pagination.results', [
                            'start' => $paginator->firstItem(),
                            'end' => $paginator->lastItem(),
                            'total' => $paginator->total(),
                        ]) !!}
                    </p>
                </div>

                <div>
                    <span class="relative z-0 inline-flex">
                        <span>
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <span aria-disabled="true" aria-label="{!! gloss('lean::resources.index.pagination.previous') !!}">
                                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 dark:text-gray-200 bg-white dark:bg-gray-600 border border-gray-300 dark:border-0 dark:border-r dark:border-gray-700 cursor-default rounded-l-md leading-5" aria-hidden="true">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                            @else
                                <button wire:click="previousPage" dusk="previousPage.after" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 dark:text-gray-200 bg-white dark:bg-gray-600 border border-gray-300 dark:border-0 dark:border-r dark:border-gray-700 rounded-l-md leading-5 hover:text-gray-400 dark:hover:text-gray-100 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{!! gloss('lean::resources.index.pagination.previous') !!}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endif
                        </span>

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 dark:text-gray-400 bg-white dark:bg-gray-600 border border-gray-300 dark:border-0 dark:border-l dark:border-r dark:border-gray-700 cursor-default leading-5">{{ $element }}</span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <span wire:key="paginator-page{{ $page }}">
                                        @if ($page == $paginator->currentPage())
                                            <span aria-current="page">
                                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 dark:text-gray-100 bg-white dark:bg-gray-600 border border-gray-300 dark:border-0 dark:border-l dark:border-r dark:border-gray-700 cursor-default leading-5">{{ $page }}</span>
                                            </span>
                                        @else
                                            <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 dark:text-gray-400 bg-white dark:bg-gray-600 border border-gray-300 dark:border-0 dark:border-l dark:border-r dark:border-gray-700 leading-5 hover:text-gray-500 dark:hover:text-gray-50 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="{!! gloss('lean::resources.index.pagination.goto', ['page' => $page]) !!}">
                                                {{ $page }}
                                            </button>
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach

                        <span>
                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                <button wire:click="nextPage" dusk="nextPage.after" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 dark:text-gray-200 bg-white dark:bg-gray-600 border border-gray-300 dark:border-0 dark:border-l dark:border-gray-700 rounded-r-md leading-5 hover:text-gray-400 dark:hover:text-gray-100 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="{!! gloss('lean::resources.index.pagination.next') !!}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @else
                                <span aria-disabled="true" aria-label="{!! gloss('lean::resources.index.pagination.next') !!}">
                                    <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 dark:text-gray-200 bg-white dark:bg-gray-600 border border-gray-300 dark:border-0 dark:border-l dark:border-gray-700 cursor-default rounded-r-md leading-5" aria-hidden="true">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                            @endif
                        </span>
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
