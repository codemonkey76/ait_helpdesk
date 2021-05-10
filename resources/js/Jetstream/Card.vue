<template>
    <div class="border dark:border-gray-600 rounded dark:bg-gray-700 bg-white dark:text-gray-200 overflow-hidden">
        <div v-show="hasHeaderSlot" class="flex justify-between bg-gray-100 dark:bg-gray-800 py-2 px-4 dark:border-gray-600 border-b">
            <slot name="header"></slot>
        </div>
        <div class="px-4 py-2 dark:text-gray-400">
            <slot></slot>
        </div>
        <div v-show="hasFooterSlot" class="flex bg-gray-100 dark:bg-gray-800 py-2 px-4 dark:border-gray-600 border-t">
            <slot name="footer"></slot>
        </div>
    </div>
</template>
<script>
export default {
    computed: {
        hasFooterSlot() {
            return !!this.$slots.footer;
        },
        hasHeaderSlot() {
            return !!this.$slots.header
        }
    }
}
</script>
