<template>
    <button @click="onUpdate" :type="type" class="inline-flex items-center px-4 py-2 border border-transparent font-semibold text-xs uppercase tracking-widest disabled:opacity-25 transition" :class="classes">
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        modelValue: Boolean,
        'onUpdate:modelValue': Function,
        type: {
            type: String,
            default: 'submit',
        },
        activeClasses: {
            type: String,
            default: 'text-white bg-brand-800 hover:bg-brand-700 active:bg-brand-900 focus:outline-none focus:border-brand-900 focus:ring-1 focus:ring-brand-300'
        },
        inactiveClasses: {
            type: String,
            default: 'border border-brand-800 text-brand-800 bg-white hover:bg-brand-900 active:bg-brand-900 hover:text-white focus:outline-none focus:border-brand-900 focus:ring-1 focus:ring-brand-300'
        }
    },
    computed: {
        classes() {
            return this.modelValue ? this.activeClasses : this.inactiveClasses
        },
    },
    methods: {
        onUpdate() {
            if (this['onUpdate:modelValue'] !== undefined) {
                this['onUpdate:modelValue'](!this.modelValue)
            }
        }
    }
}
</script>
