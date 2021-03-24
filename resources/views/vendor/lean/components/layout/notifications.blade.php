@props([
    // For how long should a notification be displayed before it's removed.
    'duration' => 1750,

    // Display stored notifications after 150ms, to give the rest of the page time to load, making things feel smoother.
    'loadDelay' => 150,
])

<div
    x-data='{
        sessionMessages: @json(session()->pull('_lean.notifications') ?? []),
        messages: {},
        pendingRemovals: {},

        add(message) {
            if (typeof message === "string") {
                message = {
                    title: message,
                    body: "",
                    link: "",
                }
            }

            let indices = Object.keys(this.messages).sort();
            let lastIndex = parseInt(indices[indices.length - 1]) || 0;
            let index = lastIndex + 1;

            this.messages[index] = message;

            this.scheduleRemoval(index);
        },

        scheduleRemoval(messageIndex) {
            // For loops we use integers
            messageIndex = parseInt(messageIndex);

            // Schedule removals for the object and all of the following ones of they dont have a removal scheduled yet.
            for (let i = messageIndex; i >= 0; i--) {
                // For object keys we use strings
                let index = i.toString();

                if (! Object.keys(this.pendingRemovals).includes(index)) {
                    this.pendingRemovals[index] = setTimeout(() => { this.remove(index) }, {!! $duration !!});
                }
            }
        },

        cancelRemoval(messageIndex) {
            // For loops we use integers
            messageIndex = parseInt(messageIndex);

            // When we cancel the removal of a message, we also want to cancel the removal of all
            // messages above it, to prevent the messages from changing position on the screen.
            for (let i = 0; i <= messageIndex; i++) {
                // For object keys we use strings
                let index = i.toString();

                clearTimeout(this.pendingRemovals[index]);
                delete this.pendingRemovals[index];
            }
        },

        remove(messageIndex) {
            let index = messageIndex.toString();

            delete this.messages[index];
            delete this.pendingRemovals[index];
        },
    }'
    x-init="window.LivewireLoaded
        ? setTimeout(() => { sessionMessages.forEach(message => { add(message) }) }, {!! $loadDelay !!})
        : document.addEventListener('livewire:load', () => {
            setTimeout(() => { sessionMessages.forEach(message => { add(message) }) }, {!! $loadDelay !!})
        })
    "
    x-on:lean-notify.window="add($event.detail)"
    class="
    fixed inset-0 py-6 pointer-events-none px-4 sm:p-6
    flex flex-col {{-- Stack notifications below each other --}}
    items-center justify-start {{-- Mobile: top center --}}
    sm:items-end sm:justify-start {{-- Desktop: top right corner --}}
    space-y-3 {{-- Space between individual notifications --}}
    z-50 {{-- Overlay modals --}}
    "
    {{ $attributes }}
>
    <template x-for="[index, message] of Object.entries(messages)" :key="index" hidden>
        <div
            x-transition:enter="transform ease-out duration-175 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-10"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-175"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="z-50 max-w-sm w-full bg-white hover:bg-brand-50 dark:bg-black dark:hover:bg-brand-900 shadow rounded-md overflow-hidden pointer-events-auto"
            @mouseenter="cancelRemoval(index)"
            @mouseleave="scheduleRemoval(index)"
        >
            <div class="rounded-lg shadow-xs">
                <div class="px-4 py-4 mt-0.5 text-sm">
                    <div class="flex justify-center space-x-3">
                        @svg('heroicon-o-information-circle', ['class' => 'block -mt-0.5 h-6 w-6 text-brand-500'])
                        <template x-if="message.link">
                            <a :href="message.link" class="flex-1">
                                <p x-text="message.title" class="font-medium text-gray-700 dark:text-gray-300"></p>
                                <p x-text="message.body" class="mt-1 text-gray-500 dark:text-gray-400"></p>
                            </a>
                        </template>
                        <template x-if="! message.link">
                            <div class="flex-1">
                                <p x-text="message.title" class="font-medium text-gray-700 dark:text-gray-300"></p>
                                <p x-text="message.body" class="mt-1 text-gray-500 dark:text-gray-400"></p>
                            </div>
                        </template>
                        <div>
                            <button
                                @click="remove(index)"
                                class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring focus:ring-brand-500 focus:ring-opacity-50"
                            >
                                @svg('heroicon-o-x', ['class' => 'h-5 w-5'])
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
