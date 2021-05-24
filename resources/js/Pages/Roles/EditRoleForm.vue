<template>
    <jet-form-section @submitted="updateRole">
        <template #title>
            Role Details
        </template>

        <template #description>
            Edit role.
        </template>

        <template #form>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Permission Name"/>
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus/>
                <jet-input-error :message="form.errors.name" class="mt-2"/>
            </div>

        </template>

        <template #actions>
            <jet-secondary-button-link :href="route('roles.index')">Cancel</jet-secondary-button-link>
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

export default {
    components: {
        JetButton,
        JetSecondaryButtonLink,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    props: ['role'],
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                name: this.role.name,
            }),
        }
    },

    methods: {
        updateRole() {
            this.form.post(route('roles.update', this.role.id), {
                errorBag: 'updateRole',
                preserveScroll: true
            });
        },
    },
}
</script>
