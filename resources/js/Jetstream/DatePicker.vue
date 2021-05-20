<template>
    <div class="flex">
        <litepie-datepicker @onUpdate:modelValue="update" :formatter="formatter" v-model="val" as-single overlay></litepie-datepicker>
    </div>
</template>
<script>
export default {
    props: ['modelValue'],
    data() {
        return {
            val: this.modelValue,
            formatter: {
                date: 'DD MMM YYYY',
                month: 'MMM'
            }
        }
    },
    methods: {
        update() {
            console.log(this.val);
        }
    }


}
</script>
