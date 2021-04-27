<template>
        <jet-form-section @submitted="createNote">
            <template #title>
                Note Details
            </template>

            <template #description>
                Create a new note.
            </template>

            <template #form>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="content" value="Content" />
                    <jet-input id="content" type="text" class="mt-1 block w-full" v-model="form.content" autofocus />
                    <jet-input-error :message="form.errors.content" class="mt-2" />
                </div>


            </template>

            <template #actions>
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create
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
        import JetSelect from '@/Jetstream/Select'

        export default {
            components: {
                JetButton,
                JetFormSection,
                JetInput,
                JetInputError,
                JetLabel,
                JetSelect
            },

            data() {
                return {
                    form: this.$inertia.form({
                        content: '',
                    })
                }
            },

            methods: {
                createNote() {
                    this.form.post(route('notes.store'), {
                        errorBag: 'createNote',
                        preserveScroll: true
                    });
                },
            },
        }
    </script>
