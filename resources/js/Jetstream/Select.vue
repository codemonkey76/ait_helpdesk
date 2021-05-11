<template>
    <select
        :id="id"
        class="dark:text-gray-200 text-gray-700 bg-white dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:bg-gray-800 border-gray-300 rounded-md focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50 shadow-md"
        :name="name"
        v-model="selected"
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
        id: String,
        name: String,
        modelValue: Number,
        options: Array,
        'onUpdate:modelValue': Function
    },
    data() {
        return {
            selected: this.modelValue
        }
    },
    methods: {
        focus() {
            this.$refs.select.focus()
        },
        changed(e) {
            if (Object.prototype.hasOwnProperty.call(this, 'onUpdate:modelValue') && this['onUpdate:modelValue'] !== undefined){
                this['onUpdate:modelValue'](parseInt(e.target.value))
                return
            }

            this.$emit('input', e.target.value)
        }
    },
}
</script>
