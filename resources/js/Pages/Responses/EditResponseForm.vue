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
                <wysiwyg id="content" v-model="form.content" :attachment-path="attachmentPath" />
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
import Wysiwyg from "../../Components/Wysiwyg";

export default {
    components: {
        Wysiwyg,
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
    computed: {
        attachmentPath() {
            let date = new Date();
            return '/attachments/' + date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
        }
    }
}
</script>
