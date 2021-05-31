<template>
    <div class="flex flex-col md:flex-row justify-between col-span-6 h-72">
        <div class="flex flex-col">
            <div class="space-y-8 divide-y dark:divide-gray-600 divide-gray-200 sm:space-y-5">
                <div class="divide-y dark:divide-gray-600 divide-gray-200 pt-8 space-y-6 sm:pt-10 sm:space-y-5">
                    <div class="space-y-6 sm:space-y-5 divide-y dark:divide-gray-600 divide-gray-200">
                        <div class="mt-4 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg space-y-4">
                                <div v-for="checkbox in checkboxes" class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <jet-checkbox @update:checked="updated" :id="checkbox.name" v-model="selectedOptions[checkbox.id]"></jet-checkbox>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label :for="checkbox.name"
                                               class="font-medium text-gray-700 dark:text-gray-200" v-text="checkbox.label" />
                                        <p class="dark:text-gray-400 text-gray-500" v-text="checkbox.description" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import JetCheckbox from "@/Jetstream/Checkbox";
export default {
    components: {JetCheckbox},
    props: ['checkboxes'],
    data() {
        return {
            selectedOptions: []
        }
    },
    methods: {
        updated() {
            this.$emit('update:modelValue', this.selectedOptions)
        }
    }
}
</script>
