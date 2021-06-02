<template>
    <jet-form-section>
        <template #title>
            Communication preferences
        </template>
        <template #description>
            Select the users preferred communication preferences
        </template>
        <template #form>
            <div class="col-span-6">
                <preferences-check-box-list
                    v-model="form.preferences"
                    :communication-preferences="$page.props.user.comms_preference" />
            </div>
        </template>

        <template #actions>
            <jet-button @click="updateUserPreferences" class="justify-center my-1"
                        :class="{ 'opacity-25': !this.changed }" :disabled="!this.changed">Update
            </jet-button>
        </template>
    </jet-form-section>
</template>
<script>
import JetButton from '@/Jetstream/Button'
import JetCheckbox from "@/Jetstream/Checkbox";
import CheckBoxList from "@/Jetstream/CheckBoxList";
import JetFormSection from '@/Jetstream/FormSection'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from "@/Jetstream/Label";
import PreferencesCheckBoxList from "@/Pages/Users/PreferencesCheckBoxList";

export default {
    components: {
        PreferencesCheckBoxList,
        CheckBoxList,
        JetLabel,
        JetCheckbox,
        JetFormSection,
        JetInputError,
        JetButton,
    },
    props: ['user'],
    data() {
        return {
            changed: false,
            test: '',
            form: this.$inertia.form({
                _method: 'PATCH',
                preferences: ''
            })
        }
    },
    methods: {
        updateUserPreferences() {
            // this.form.patch(route('users.companies.store', this.user.id), {
            //     errorBag: 'addCompanyToUser',
            //     preserveScroll: true,
            //     onSuccess: () => this.addItem = null
            // })
        },

    },
}
</script>
