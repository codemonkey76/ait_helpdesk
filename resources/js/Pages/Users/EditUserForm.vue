<template>
    <jet-form-section @submitted="updateUser">
        <template #title>
            User Details
        </template>

        <template #description>
            Edit user.
        </template>

        <template #form>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="User Name"/>
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus/>
                <jet-input-error :message="form.errors.name" class="mt-2"/>
            </div>

        </template>

        <template #actions>
            <jet-secondary-button-link :href="route('users.index')">Cancel</jet-secondary-button-link>
            <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
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

export default {
    components: {
        JetButton,
        JetSecondaryButtonLink,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSelect
    },
    props: ['user'],

    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                name: this.user.name,
            }),
        }
    },

    methods: {
        updateUser() {
            this.form.post(route('users.update', this.user.id), {
                errorBag: 'updateUser',
                preserveScroll: true
            });
        },
    },
}
</script>
