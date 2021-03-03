<div
    x-data="{
        expanded: false,
        hardcodedClassesPresent: true,
        removeHardcodedClasses() {
            this.$refs.menu.classList.remove('sm:block');
            this.$refs.menu.classList.remove('hidden');

            this.hardcodedClassesPresent = false;
        },
        toggleMenu() {
            if (this.hardcodedClassesPresent) {
                this.removeHardcodedClasses();
            }

            this.expanded = ! this.expanded;
        }
    }"
    class="flex flex-col"
>
    <div class="flex flex-row sm:hidden px-4 py-4 w-full">
        @if(Lean::isCurrentAction('index') || request()->routeIs('lean.page'))
            <div class="inline-flex items-center" @click.stop="toggleMenu">
                <button type="button">
                    @svg('heroicon-o-menu', ['class' => 'h-6 w-6'])
                </button>
                <span class="ml-2 font-medium">
                    {{ $title ?? '' }}
                </span>
            </div>
        @else
            <div class="w-full flex justify-between">
                <div class="inline-flex items-center">
                    <button type="button" onclick="window.history.back()">
                        @svg('heroicon-o-arrow-left', ['class' => 'h-6 w-6'])
                    </button>
                    <span class="ml-2 font-medium">
                        {{ $title ?? '' }}
                    </span>
                </div>

                {{-- Sometimes the browser history may disappear so we make sure to also always display the toggle button --}}
                <div class="inline-flex items-center" @click.stop="toggleMenu">
                    <button type="button">
                        @svg('heroicon-o-menu', ['class' => 'h-6 w-6'])
                    </button>
                </div>
            </div>
        @endif
    </div>

    <div
        x-show="expanded"
        x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
        class="absolute sm:static sm:block-important hidden bg-gray-50 min-h-full py-4 w-72 max-w-full sm:w-64 z-40"
        x-ref="menu"
        @click.away="expanded = false"
    >
        <div class="w-full text-gray-700 font-medium text-2xl text-center">{{ Lean::name() }}</div>
        <x-lean::navigation.items />
    </div>

    <div
        x-show="expanded"
        x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-out duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        x-cloak
        class="absolute transition-opacity z-30"
    >
        <div class="absolute top-0 left-0 w-screen h-screen bg-gray-500 opacity-50"></div>
    </div>
</div>
