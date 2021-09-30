<template>
    <jet-form-section @submitted="createTicket">
        <template #title>
            Ticket Details
        </template>

        <template #description>
            Create a new ticket.
        </template>

        <template #form>

            <div class="col-span-6">
                <jet-label for="subject" value="Subject" />
                <jet-input id="subject" type="text" class="mt-1 block w-full" v-model="form.subject" autofocus />
                <jet-input-error :message="form.errors.subject" class="mt-2" />
            </div>

            <div class="col-span-6">
                <jet-label for="content" value="Content" />
                <wysiwyg id="content" v-model="form.content" :attachment-path="attachmentPath" />
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
                Create
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetSelect from '@/Jetstream/Select'
import JetText from '@/Jetstream/TextArea'
import Wysiwyg from "../../Components/Wysiwyg";

export default {
    components: {
        Wysiwyg,
        JetButton,
        JetSecondaryButtonLink,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSelect,
        JetText
    },
    data() {
        return {
            form: this.$inertia.form({
                subject: '',
                content: '',
                company_id: this.default_company
            })
        }
    },
    computed: {
        default_company() {
            return (this.$page.props.companyOptions?.length)? this.$page.props.companyOptions[0].id : null;
        },
        attachmentPath() {
            let date = new Date();
            return '/attachments/' + date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
        }
    },
    methods: {
        createTicket() {
            this.form.post(route('tickets.store'), {
                errorBag: 'createTicket',
                preserveScroll: true
            });
        },
    },
}
</script>
