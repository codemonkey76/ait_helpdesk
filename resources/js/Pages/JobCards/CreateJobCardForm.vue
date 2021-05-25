<template>
    <jet-form-section @submitted="createJobCard">
        <template #title>
            Job Card Details
        </template>

        <template #description>
            Create a new job card.
        </template>

        <template #form>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Job Details" />
                <jet-text id="name" type="text" class="mt-1 block w-full" v-model="form.content" autofocus :rows="15" />
                <jet-input-error :message="form.errors.content" class="mt-2" />
            </div>
            <div class="col-span-6">
                <jet-label for="time_spent" value="Time Spent"/>
                <jet-select
                    :options="$page.props.timeOptions"
                    v-model="form.time_spent">
                </jet-select>
                <jet-input-error :message="form.errors.time_spent" class="mt-2"/>
            </div>

        </template>

        <template #actions>
            <jet-secondary-button-link :href="route('tickets.show', ticket.id)">Cancel</jet-secondary-button-link>
            <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Close Ticket
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetText from '@/Jetstream/TextArea'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetSelect from '@/Jetstream/Select'

export default {
    components: {
        JetButton,
        JetSecondaryButtonLink,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetText,
        JetSelect
    },
    props: ['ticket'],
    data() {
        return {
            form: this.$inertia.form({
                content: this.ticket.jobSummary,
                time_spent: this.ticket.timeSummary
            })
        }
    },

    methods: {
        createJobCard() {
            this.form.post(route('tickets.job-card.store', this.ticket.id), {
                errorBag: 'createJobCard',
                preserveScroll: true
            });
        },
    },
}
</script>
