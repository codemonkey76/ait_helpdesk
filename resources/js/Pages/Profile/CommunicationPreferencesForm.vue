<template>
    <jet-form-section @submitted="updateCommunicationPreferences">
        <template #title>Communication Preferences</template>
        <template #description>Choose your preferred contact method for receiving updates</template>
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <div class="flex space-x-2">
                    <div class="flex space-x-2">
                <jet-label for="pref_sms" value="SMS"/>
                <input
                    class="dark:bg-gray-900 rounded border-gray-300 text-brand-600 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50"
                    type="checkbox"
                    name="pref_sms"
                    id="pref_sms"
                    value="NotificationChannels\Twilio\TwilioChannel"
                    v-model="form.comms_preference">
                </div>

                    <div class="flex space-x-2">
                    <jet-label for="pref_email" value="Email"/>

                    <input
                    class="dark:bg-gray-900 rounded border-gray-300 text-brand-600 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50"
                    type="checkbox"
                    name="pref_email"
                    id="pref_email"
                    value="mail"
                    v-model="form.comms_preference">
                </div>
                </div>
            </div>
        </template>
        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>

        </template>
    </jet-form-section>
</template>
<script>
import JetLabel from '@/Jetstream/Label'
import JetInput from '@/Jetstream/Input'
import JetButton from '@/Jetstream/Button'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetFormSection from '@/Jetstream/FormSection'
import JetCheckbox from "@/Jetstream/Checkbox";
export default {
    props: ['user'],
    components: {
        JetCheckbox,
        JetFormSection,
        JetActionMessage,
        JetButton,
        JetInput,
        JetLabel
    },
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PATCH',
                comms_preference: this.user.comms_preference
            }),
        }
    },
    methods: {
        updateCommunicationPreferences() {
            this.form.patch(route('user-communication-preferences.update'), {
                errorBag: 'updateCommunicationPreferences',
                preserveScroll: true
            });
        }
    }
}
</script>
