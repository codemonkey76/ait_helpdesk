<template>
    <input
        class="dark:bg-gray-900 dark:text-gray-400 dark:placeholder-gray-700 border-gray-300 focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="placeholder"
        ref="input">
</template>

<script>
    export default {
        props: ['modelValue', 'placeholder'],

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>

