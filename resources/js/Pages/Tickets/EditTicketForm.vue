<template>
    <jet-form-section @submitted="updateTicket">
        <template #title>
            Ticket Details
        </template>

        <template #description>
            Edit ticket.
        </template>

        <template #form>

            <div class="col-span-6">
                <jet-label for="subject" value="Subject" />
                <jet-input id="subject" type="text" class="mt-1 block w-full" v-model="form.subject" autofocus />
                <jet-input-error :message="form.errors.subject" class="mt-2" />
            </div>

            <div class="col-span-6">
                <jet-label for="content" value="Content" />
                <editor id="content" v-model="form.content"></editor>
                <jet-input-error :message="form.errors.content" class="mt-2" />
            </div>

            <div class="col-span-6">
                <jet-label for="company_id" value="Company" />
                <jet-select
                    :options="$page.props.companyOptions"
                    v-model="form.company_id">
                    <template v-if="!default_company" #none-selected>
                        <option :value="null">None selected</option>
                    </template>
                </jet-select>
                <jet-input-error :message="form.errors.company_id" class="mt-2" />
            </div>



        </template>

        <template #actions>
            <jet-secondary-button-link :href="route('tickets.index')">Cancel</jet-secondary-button-link>
            <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import Editor from "@/Jetstream/Editor";
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetSelect from '@/Jetstream/Select'
import JetText from '@/Jetstream/TextArea'

export default {
    components: {
        Editor,
        JetButton,
        JetSecondaryButtonLink,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSelect,
        JetText
    },
    props: ['ticket'],
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PATCH',
                subject: this.ticket.subject,
                content: this.ticket.content,
                company_id: this.ticket.company_id
            })
        }
    },
    methods: {
        updateTicket() {
            this.form.patch(route('tickets.update', this.ticket.id), {
                errorBag: 'updateTicket',
                preserveScroll: true
            });
        },
    },
}
</script>
