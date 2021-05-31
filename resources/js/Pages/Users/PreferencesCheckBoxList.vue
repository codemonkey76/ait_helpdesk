<template>
    <jet-check-box-list @update:modelValue="updated" :checkboxes="checkboxes" ></jet-check-box-list>
</template>
<script>
import JetCheckBoxList from "@/Jetstream/CheckBoxList";
export default {
    components: {JetCheckBoxList},
    data() {
        return {
            checkboxes: [
                {
                    id: 0,
                    name: 'email',
                    label: 'Email',
                    description: 'Receive emails when your tickets are responded to.'
                }, {
                    id: 1,
                    name: 'sms',
                    label: 'SMS',
                    description: 'Get an SMS notification when your tickets are responded to, requires the user to verify their phone number.'
                }
            ]
        }
    },
    methods: {
        updated(e) {
            this.$emit('update:modelValue', e)
        }
    }
}
</script>
