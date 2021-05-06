<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 dark:bg-gray-900 bg-white border dark:border-gray-600 border-gray-300 rounded-md font-semibold text-xs dark:text-gray-400 text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-brand-300 focus:ring focus:ring-brand-200  dark:active:text-gray-200 dark:active:bg-gray-800 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition dark:hover:text-gray-400 dark:hover:bg-gray-800">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
            },
        }
    }
</script>
