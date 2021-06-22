<template>
    <jet-form-section @submitted="createBug">
        <template #title>
            Bug Details
        </template>

        <template #description>
            Report a bug, please include steps to reproduce if applicable
        </template>

        <template #form>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="subject" value="Subject" />
                <jet-input id="subject" type="text" class="mt-1 block w-full" v-model="form.subject" autofocus />
                <jet-input-error :message="form.errors.subject" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="content" value="Content" />
                <editor id="content" v-model="form.content" />
                <jet-input-error :message="form.errors.content" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-secondary-button-link :href="route('dashboard')">Cancel</jet-secondary-button-link>
            <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Report
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
import Editor from "../../Jetstream/Editor";

export default {
    components: {
        Editor,
        JetButton,
        JetSecondaryButtonLink,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSelect
    },

    data() {
        return {
            form: this.$inertia.form({
                subject: '',
                content: ''
            })
        }
    },

    methods: {
        createBug() {
            this.form.post(route('bugs.store'), {
                errorBag: 'createBug',
                preserveScroll: true
            });
        },
    }
}
</script>
