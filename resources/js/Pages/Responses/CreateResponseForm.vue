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
                <editor id="content" v-model="form.content" />
                <jet-input-error :message="form.errors.content" class="mt-2" />
            </div>

            <div class="col-span-6">
                <jet-label for="private" value="Private" />
                <jet-checkbox id="private" v-model="form.private" />
                <jet-input-error :message="form.errors.private" class="mt-2" />
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
            <jet-secondary-button-link :href="route('tickets.show', ticket.id)">Cancel</jet-secondary-button-link>
            <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import CustomSelect from "@/Jetstream/CustomSelect";
import Editor from "@/Jetstream/Editor";
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetSelect from '@/Jetstream/Select'
import JetText from '@/Jetstream/TextArea'
import JetCheckbox from '@/Jetstream/Checkbox'
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'

export default {
    components: {
        Editor,
        CustomSelect,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSelect,
        JetSecondaryButtonLink,
        JetText,
        JetCheckbox
    },
    props: ['status', 'ticket'],
    data() {
        return {
            form: this.$inertia.form({
                content: '',
                private: false,
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
