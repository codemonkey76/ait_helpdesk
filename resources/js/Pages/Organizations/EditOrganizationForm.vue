<template>
    <jet-form-section @submitted="updateOrganization">
        <template #title>
            Organization Details
        </template>

        <template #description>
            Edit organization.
        </template>

        <template #form>


            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Organization Name"/>
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus/>
                <jet-input-error :message="form.errors.name" class="mt-2"/>
            </div>

            <jet-select class="col-span-6 sm:col-span-4"
                        :options="$page.props.headOfficeOptions"
                        v-model="form.head_office_id">
                <template #none-selected>
                    <option :value="null">None selected</option>
                </template>
            </jet-select>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Organization Name"/>
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus/>
                <jet-input-error :message="form.errors.name" class="mt-2"/>
            </div>

        </template>

        <template #actions>
                <jet-secondary-button-link :href="route('organizations.index')">Cancel</jet-secondary-button-link>
                <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Save
                </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'
import JetCombo from '@/Jetstream/Combo'
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
        JetCombo,
        JetSelect
    },
    props: ['organization'],
    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                name: this.organization.name,
                head_office_id: this.organization.head_office_id
            }),
        }
    },

    methods: {
        updateOrganization() {
            this.form.post(route('organizations.update', this.organization.id), {
                errorBag: 'updateOrganization',
                preserveScroll: true
            });
        },
    },
}
</script>
