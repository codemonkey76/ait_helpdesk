<template>
    <select @input="input" :value="modelValue">
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
    </select>
</template>
<script>
export default {
    props: ['modelValue', 'onUpdate:modelValue'],
    methods: {
        input(e) {
            this['onUpdate:modelValue'](e.target.value)
        }
    }
}
</script>
