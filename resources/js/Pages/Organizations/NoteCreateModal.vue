<template>
    <jet-dialog-modal :show="show" @close="closeModal">
        <template #title>
            Create Note
        </template>

        <template #content>
            Adding Note

            <div class="mt-4">

                <jet-text type="text" class="mt-1 block w-full" placeholder="Enter note here"
                           ref="content"
                           v-model="form.content" />

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
import JetDialogModal from '@/Jetstream/DialogModal'
import JetButton from '@/Jetstream/Button'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetText from '@/Jetstream/TextArea'

export default {
    components: {
        JetActionSection,
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        JetText
    },
    props: ['show', 'noteableId', 'noteableType'],

    data() {
        return {
            form: this.$inertia.form({
                password: '',
                'noteable_id': this.noteableId,
                'notable_type': this.notableType,
            })
        }
    },

    methods: {
        deleteCompany() {
            this.closeModal();
            this.form.post(route('notes.store', this.company.id), {
                preserveScroll: true,
            })
        },

        closeModal() {
            this.form.reset()
            this.$emit('closeModal')
        },
    },
}
</script>
