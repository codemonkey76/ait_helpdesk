<template>
    <jet-form-section @submitted="updateResponse">
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

        </template>

        <template #actions>
            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update
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
        JetText
    },
    props: ['response'],
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PATCH',
                content: this.response.content,
            })
        }
    },
    methods: {
        updateResponse() {
            this.form.patch(route('tickets.responses.update', [this.response.ticket_id, this.response.id]), {
                errorBag: 'updateResponse',
                preserveScroll: true
            });
        },
    },
}
</script>
