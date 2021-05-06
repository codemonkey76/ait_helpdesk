<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest disabled:opacity-25 transition" :class="classes">
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        active: {
            type: Boolean,
        },
        type: {
            type: String,
            default: 'submit',
        },
        activeClasses: {
            type: String,
            default: 'text-white bg-brand-800 hover:bg-brand-700 active:bg-brand-900 focus:outline-none focus:border-brand-900 focus:ring focus:ring-brand-300'
        },
        inactiveClasses: {
            type: String,
            default: 'border border-brand-800 text-brand-800 bg-white hover:bg-brand-900 active:bg-brand-900 hover:text-white focus:outline-none focus:border-brand-900 focus:ring focus:ring-brand-300'
        }
    },
    computed: {
        classes() {
            return this.active ? this.activeClasses : this.inactiveClasses
        },
    }
}
</script>
