<template>
    <select
        class="border-gray-300 rounded-md focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50 shadow-md"
        :value="modelValue"
        @change="changed"
        ref="select">
        <slot name="none-selected">
        </slot>
        <option v-for="(option, key) of options" v-text="option.name" :value="option.id"/>
    </select>
</template>
<script>
export default {
    props: {
        modelValue: String,
        options: Array,
    },
    emits: ['update:modelValue'],
    methods: {
        focus() {
            this.$refs.select.focus()
        },
        changed(e) {
            this.$emit('update:modelValue', e.target.value)
        }
    },
}
</script>
