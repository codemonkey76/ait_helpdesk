<template>
    <jet-form-section @submitted="createResponse">
        <template #title>
            Response Details
        </template>

        <template #description>
            Respond to the ticket.
        </template>

        <template #form>

            <div class="col-span-6">
                <jet-label for="content" value="Content" />
                <jet-text id="content" tclass="mt-1 block w-full" v-model="form.content" autofocus />
                <jet-input-error :message="form.errors.content" class="mt-2" />
            </div>

            <div v-if="$page.props.permissions.canChangeTicketStatus" class="col-span-6">
                <jet-label for="status_id" value="Status" />
                <jet-select
                    id="status_id"
                    :options="$page.props.statusOptions"
                    v-model="form.status_id">
                </jet-select>
                <span class="text-gray-500 ml-2" v-text="statusDescription(form.status_id)" />
                <jet-input-error :message="form.errors.status_id" class="mt-2" />
            </div>

        </template>

        <template #actions>
            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import CustomSelect from "@/Jetstream/CustomSelect";
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetSelect from '@/Jetstream/Select'
import JetText from '@/Jetstream/TextArea'

export default {
    components: {
        CustomSelect,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSelect,
        JetText
    },
    props: ['status', 'ticket'],
    data() {
        return {
            form: this.$inertia.form({
                content: '',
                status_id: this.ticket.status_id
            })
        }
    },
    methods: {
        createResponse() {
            this.form.post(route('tickets.responses.store', this.ticket.id), {
                errorBag: 'createResponse',
                preserveScroll: true
            });
        },
        statusDescription(id) {
            return this.status.find(x => parseInt(x.id) === parseInt(id))?.description
        }
    },
}
</script>
