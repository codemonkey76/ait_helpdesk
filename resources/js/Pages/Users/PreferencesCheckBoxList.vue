<template>
    <jet-check-box-list @update:modelValue="updated" :checkboxes="checkboxes" :value="communicationPreferences"></jet-check-box-list>
</template>
<script>
import JetCheckBoxList from "@/Jetstream/CheckBoxList";
export default {
    props: ['communicationPreferences'],
    components: {JetCheckBoxList},
    data() {
        return {
            checkboxes: [
                {
                    id: 0,
                    name: 'comms_preferences',
                    value: 'email',
                    label: 'Email',
                    description: 'Receive emails when your tickets are responded to.'
                }, {
                    id: 1,
                    name: 'comms_preferences',
                    value: 'sms',
                    label: 'SMS',
                    description: 'Get an SMS notification when your tickets are responded to, requires the user to verify their phone number.'
                }
            ]
        }
    },
    methods: {
        updated(e) {
            this.$emit('update:modelValue', e)
            console.log('clicked')
            console.log(e);
        }
    }
}
</script>
