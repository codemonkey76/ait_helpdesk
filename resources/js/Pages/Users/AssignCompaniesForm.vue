<template>
    <jet-form-section>
        <template #title>
            Assign companies
        </template>
        <template #description>
            Assign all companies that this user will be able to create tickets on behalf of
        </template>
        <template #form>
            <div class="flex justify-between col-span-6 h-72">
                <div>
                    <jet-label>Company List</jet-label>
                    <stacked-list></stacked-list>
                </div>
                <div class="flex flex-col">
                    <jet-button>Add</jet-button>
                </div>
                <div>
                    <jet-label>Assigned companies</jet-label>
                    <stacked-list></stacked-list>
                </div>

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
import JetLabel from '@/Jetstream/Label'
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'
import StackedList from "@/Jetstream/StackedList";

export default {
    components: {
        StackedList,
        JetFormSection,
        JetButton,
        JetLabel,
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
