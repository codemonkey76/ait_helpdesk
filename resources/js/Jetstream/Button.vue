<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest disabled:opacity-25 transition" :class="styles">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'submit',
            },
            styles: {
                type: String,
                default: 'text-white bg-brand-800 hover:bg-brand-700 active:bg-brand-900 focus:outline-none focus:border-brand-900 focus:ring focus:ring-brand-300'
            },
        }
    }
</script>
