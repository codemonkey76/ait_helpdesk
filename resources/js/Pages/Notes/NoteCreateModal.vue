<template>
    <jet-dialog-modal :show="show" @close="closeModal">
        <template #title>
            Create Note
        </template>

        <template #content>
            Adding Note

            <div class="mt-4">

                <jet-label for="content" value="Note content" />
                <wysiwyg id="content" ref="content" v-model="form.content" :attachment-path="attachmentPath" />
                <jet-input-error :message="form.errors.content" class="mt-2"/>
            </div>
        </template>

        <template #footer>
            <jet-secondary-button @click="closeModal">
                Cancel
            </jet-secondary-button>

            <jet-button class="ml-2" @click="addNote" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                Add Note
            </jet-button>
        </template>
    </jet-dialog-modal>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetButton from '@/Jetstream/Button'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetText from '@/Jetstream/TextArea'
import JetLabel from '@/Jetstream/Label'
import Editor from '@/Jetstream/Editor'
import Wysiwyg from "../../Components/Wysiwyg";


export default {
    components: {
        Wysiwyg,
        Editor,
        JetActionSection,
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        JetText,
        JetLabel
    },
    props: ['show', 'noteableId', 'noteableType'],

    data() {
        return {
            form: this.$inertia.form({
                content: '',
                'noteable_id': this.noteableId,
                'noteable_type': this.noteableType,
            })
        }
    },

    methods: {
        addNote() {
            this.form.post(route('notes.store'), {
                errorBag: 'createNote',
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.content.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        closeModal() {
            this.form.reset()
            this.$emit('closeModal')
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
