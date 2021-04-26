<template>

    <jet-dropdown class="col-span-6 sm:col-span-4" align="left" width="60">
        <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                            {{ selectedText }}
                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </span>
        </template>

        <template #content>
            <div class="block w-60 outline-none">
                <div class="block px-4 py-2 text-xs text-gray-400" v-text="placeholder" />
                <a @click.prevent="selectOption(option)" href="#" v-for="(option,key) in options" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition" v-text="option.name" />
            </div>
        </template>
    </jet-dropdown>
</template>
<script>
import JetDropdown from '@/Jetstream/Dropdown'

export default {
    components: {
        JetDropdown,
    },
    props: ['placeholder', 'options', 'value'],
    data() {
        return {
            selected: this.value
        }
    },
    methods: {
        selectOption(option) {
            this.selected = option.value;
            this.$emit('input', option.value)
            console.log('outputting input event for ' + option.value)
        },
    },
    computed: {
        selectedText() {
            let option = this.options.find(x=>x.value===this.selected);

            if (typeof option !== 'undefined') return option.name;
            return "None selected"
        }
    }
}
</script>
