export default function (config) {
    return {
        data: config.data,

        emptyOptionsMessage: config.emptyOptionsMessage ?? 'No results match your search.',

        focusedOptionIndex: null,

        name: config.name,

        open: false,

        options: {},

        placeholder: config.placeholder ?? 'Select an option',

        search: '',

        values: config.values || [config.value],

        closeListbox: function () {
            this.open = false

            this.focusedOptionIndex = null

            this.search = ''
        },

        ensureListboxIsOpen: function () {
            this.open = true
        },

        focusNextOption: function () {
            if (this.focusedOptionIndex === null) return this.focusedOptionIndex = Object.keys(this.options).length - 1

            if (this.focusedOptionIndex + 1 >= Object.keys(this.options).length) return

            this.focusedOptionIndex++

            this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                block: "center",
            })
        },

        focusPreviousOption: function () {
            if (this.focusedOptionIndex === null) return this.focusedOptionIndex = 0

            if (this.focusedOptionIndex <= 0) return

            this.focusedOptionIndex--

            this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                block: "center",
            })
        },

        init: function () {
            this.options = this.data

            if (! Array.isArray(this.values)) {
                this.values = []
            }

            if (! this.values.every(value => Object.keys(this.options).includes(value))) {
                this.values = []
            }

            this.$watch('search', ((value) => {
                if (!this.open || !value) return this.options = this.data

                this.focusedOptionIndex = 0

                this.options = Object.keys(this.data)
                .filter((key) => this.data[key].toLowerCase().includes(value.toLowerCase()))
                .reduce((options, key) => {
                    options[key] = this.data[key]
                    return options
                }, {})
            }))
        },

        selectOption: function () {
            const option = Object.keys(this.options)[this.focusedOptionIndex]

            // this.values = [1,2,3, 4];
            if (this.values.includes(option)) {
                this.values.splice(this.values.indexOf(option), 1)
            } else {
                this.values.push(option)
            }
        },

        toggleListboxVisibility: function () {
            if (this.open) return this.closeListbox()

            // this.focusedOptionIndex = Object.keys(this.options).indexOf(this.value)

            // if (this.focusedOptionIndex < 0) this.focusedOptionIndex = 0

            this.openListbox()
        },

        openListbox: function () {
            this.focusedOptionIndex = 0

            this.open = true

            this.$nextTick(() => {
                this.$refs.search.focus()

                this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                    block: "nearest"
                })
            })
        },

        blurredInput: function () {
            this.$nextTick(() => {
                if (! this.$el.contains(document.activeElement)) {
                    this.closeListbox()
                }
            })
        }
    }
};
