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
                    <wysiwyg id="content" v-model="form.content" :attachment-path="attachmentPath" />
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
        import Editor from "@/Jetstream/Editor";
        import Wysiwyg from "../../Components/Wysiwyg";

        export default {
            components: {
                Wysiwyg,
                JetButton,
                JetFormSection,
                JetInput,
                JetInputError,
                JetLabel,
                JetSelect,
                Editor
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
            computed: {
                attachmentPath() {
                    let date = new Date();
                    return '/attachments/' + date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
                }
            }
        }
    </script>
