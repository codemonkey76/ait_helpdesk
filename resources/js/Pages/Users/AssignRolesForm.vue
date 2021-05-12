<template>
    <jet-form-section>
        <template #title>
            Assign roles
        </template>
        <template #description>
            Assign roles that user needs permissions for
        </template>
        <template #form>

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
import JetFormSection from '@/Jetstream/FormSection'
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'

export default {
    components: {
        JetFormSection,
        JetButton,
        JetSecondaryButtonLink
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
}
</script>
