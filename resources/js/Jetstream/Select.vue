<template>
    <select
        class="dark:text-gray-200 text-gray-700 bg-white dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:bg-gray-800  border-gray-300 rounded-md focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50 shadow-md"
        :name="name"
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
        name: String,
        modelValue: Number,
        options: Array,
    },
    data() {
        return {
            selected: this.default ? this.default : this.options.length > 0 ? this.options[0].id : null
        }
    },
    mounted() {
        this.$emit("onUpdate:modelValue", this.selected);
    },
    methods: {
        focus() {
            this.$refs.select.focus()
        },
        changed(e) {
            this.$emit('onUpdate:modelValue', e.target.value)
        }
    },
}
</script>
