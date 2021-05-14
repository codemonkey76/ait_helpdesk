<template>
    <nav class="border dark:border-gray-600 overflow-y-auto rounded flex-1">
        <div v-if="grouped">
            <div v-for="(group,key) in data" class="relative">
                <div v-if="group.length"
                    class="z-10 sticky top-0 border-t border-b px-6 py-1 text-sm font-medium "
                    :class="groupStyles">
                    <h3 v-text="key"/>
                </div>
                <ul class="relative z-0 divide-y dark:divide-gray-600 divide-gray-200">
                    <li v-for="item in group">
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 focus-within:ring-2 focus-within:ring-inset"
                            :class="itemStyle(item)"
                        >
                            <div class="flex-1 min-w-0">
                                <a href="#" @click.prevent="selectItem(item)" class="focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p
                                        class="text-sm font-medium"
                                        :class="titleStyle(item)"
                                        v-text="item[titleField]"/>
                                    <p
                                        class="text-sm truncate"
                                        :class="subtitleStyle(item)"
                                        v-text="item[subtitleField]"/>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div v-else>
            <div class="relative">
                <ul class="relative z-0 divide-y divide-gray-200">
                    <li v-for="item in data">
                        <div
                            class="relative px-6 py-5 flex items-center space-x-3 focus-within:ring-2 focus-within:ring-inset"
                            :class="itemStyle(item)">
                            <div class="flex-1 min-w-0">
                                <a href="#" @click.prevent="selectItem(item)" class="focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium"
                                       :class="titleStyle(item)"
                                       v-text="item[titleField]"/>
                                    <p class="text-sm truncate"
                                       :class="subtitleStyle(item)"
                                       v-text="item[subtitleField]"/>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    props: {
        grouped: {
            type: Boolean,
            default: false
        },
        data: {
            type: Object,
            default: []
        },
        titleField: {
            type: String,
            default: 'name'
        },
        subtitleField: {
            type: String,
            default: 'description'
        },
        groupStyles: {
            type: String,
            default: ' dark:bg-gray-800 bg-gray-50 dark:border-gray-600 dark:text-gray-400 border-gray-200 text-gray-500'
        },
        itemStyles: {
            type: String,
            default: 'dark:bg-gray-900 dark:hover:bg-gray-800 bg-white hover:bg-gray-50 focus-within:ring-brand-500'
        },
        selectedItemStyles: {
            type: String,
            default: 'bg-brand-800 hover:bg-brand-700 focus-within:ring-brand-500'
        },
        titleStyles: {
            type: String,
            default: 'text-gray-900 dark:text-gray-200'
        },
        subtitleStyles: {
            type: String,
            default: 'text-gray-500 dark:text-gray-400'
        },
        selectedTitleStyles: {
            type: String,
            default: 'text-gray-200'
        },
        selectedSubtitleStyles: {
            type: String,
            default: 'text-gray-400'
        },
        selectedItem: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            selected: this.selectedItem
        }
    },
    methods: {
        itemStyle(item) {
            if (item === this.selected)
                return this.selectedItemStyles

            return this.itemStyles
        },
        titleStyle(item) {
            if (item === this.selected)
                return this.selectedTitleStyles

            return this.titleStyles
        },
        subtitleStyle(item) {
            if (item === this.selected)
                return this.selectedSubtitleStyles

            return this.subtitleStyles
        },
        selectItem(item) {
            if (item === this.selected) {
                this.selected = null;
                this.$emit('selected', null)
                return
            }

            this.selected = item
            this.$emit('selected', item)
        },

    },
}
</script>
