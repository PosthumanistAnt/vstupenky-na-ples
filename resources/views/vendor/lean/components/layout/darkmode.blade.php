<x-lean::layout.component :attributes="$attributes">
    <x-slot name="head">
        <script>
            if (localStorage.leanTheme === 'dark' || (! ('leanTheme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </x-slot>
    <x-slot name="toggle">
        <div x-data="Alpine.component('darkModeToggle')()"
            class="bg-gray-100 text-gray-400 text:black dark:bg-gray-700 mx-8 rounded-full py-2 flex justify-around items-center px-2 space-x-1"
        >
            <button type="button" @click="switchTheme('light')"
                class="relative transition focus:outline-none flex-grow flex px-3 justify-center items-center rounded-full py-1.5"
                :class="{
                    'text-gray-600 dark:text-gray-300': themeIs('light'),
                    'text-gray-400 dark:text-gray-500': ! themeIs('light'),
                }"
            >
                <div class="absolute rounded-full bg-white dark:bg-gray-500 w-full h-full" x-cloak x-show="themeIs('light')"
                    x-transition:enter="transition transform ease-out0"
                        x-transition:enter-start="translate-x-1/2"
                        x-transition:enter-end="translate-x-0"
                ></div>
                @svg('heroicon-o-sun', ['class' => 'h-5 w-5 z-10'])
            </button>

            <button type="button" @click="resetTheme()"
                class="relative transition focus:outline-none flex-shrink-0 flex px-3 justify-center items-center rounded-full py-1.5"
                :class="{
                    'text-gray-600 dark:text-gray-300': themeIs(null),
                    'text-gray-400 dark:text-gray-500': ! themeIs(null),
                }"
            >
                <div class="absolute rounded-full bg-white dark:bg-gray-500 w-full h-full" x-cloak x-show="themeIs(null)"
                    x-transition:enter="transition transform ease-out"
                        :x-transition:enter-start="previousTheme === 'light' ? '-translate-x-1/2' : 'translate-x-1/2'"
                        x-transition:enter-end="translate-x-0"
                ></div>
                @svg('heroicon-o-desktop-computer', ['class' => 'h-5 w-5 z-10'])
            </button>

            <button type="button" @click="switchTheme('dark')"
                class="relative transition focus:outline-none flex-grow flex px-3 justify-center items-center rounded-full py-1.5"
                :class="{
                    'text-gray-600 dark:text-gray-300': themeIs('dark'),
                    'text-gray-400 dark:text-gray-500': ! themeIs('dark'),
                }"
            >
                <div class="absolute rounded-full bg-white dark:bg-gray-500 w-full h-full" x-cloak x-show="themeIs('dark')"
                    x-transition:enter="transition transform ease-out"
                        x-transition:enter-start="-translate-x-1/2"
                        x-transition:enter-end="translate-x-0"
                ></div>
                @svg('heroicon-o-moon', ['class' => 'h-5 w-5 z-10'])
            </button>
        </div>
    </x-slot>
</x-lean::layout.component>
