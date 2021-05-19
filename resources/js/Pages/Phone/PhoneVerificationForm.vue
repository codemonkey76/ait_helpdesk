<template>
    <jet-form-section @submitted="verify">
        <template #title>
            Verify your phone number
        </template>

        <template #description>
            You need to verify your phone number before you can get SMS updates on any tickets.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label value="Phone number"></jet-label>
                <jet-input v-model="sendCodeForm.phone" id="phone" type="text" class="w-full" readonly></jet-input>
                <jet-button @click.prevent="sendCode" class="mt-2" :class="{ 'opacity-25': codeSent }" :disabled="codeSent">Send Verification Code</jet-button>
                <jet-action-message :on="codeSent" color="text-green-600">
                    Verification code has been sent successfully!<br />please allow 1-2 minutes for delivery.
                </jet-action-message>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="verification_code" value="Verification code"></jet-label>
                <jet-input v-model="form.phone_verification_code" id="phone_verification_code" type="text"
                           class="w-full"></jet-input>
                <jet-input-error :message="form.errors.phone_verification_code" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Verify
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
    },

    props: ['user'],

    data() {
        return {
            codeSent: false,
            sendCodeForm: this.$inertia.form({
                _method: 'POST',
                phone: this.user.phone,
            }),
            form: this.$inertia.form({
                _method: 'POST',
                phone_verification_code: ''
            }),
        }
    },

    methods: {
        verify() {
            this.form.post(route('phone.verify'),{
                preserveScroll:true
            })

        },
        sendCode() {
            this.sendCodeForm.post(route('phone.verify.send'),{
                preserveScroll: true,
                onSuccess: () => {
                    this.codeSent = true
                }
            })
        }
    },
}
</script>
