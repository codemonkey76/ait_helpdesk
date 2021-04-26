<template>
    <jet-action-section>
        <template #title>
            Delete Organization
        </template>

        <template #description>
            Permanently delete this organization.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once this organization is deleted, all of its resources and data will be permanently deleted. Before deleting the organization, please download any data or information that you wish to retain.
            </div>

            <div class="mt-5">
                <jet-danger-button @click="confirmOrganizationDeletion">
                    Delete Organization
                </jet-danger-button>
            </div>

            <!-- Delete Organization Confirmation Modal -->
            <jet-dialog-modal :show="confirmingOrganizationDeletion" @close="closeModal">
                <template #title>
                    Delete Organization
                </template>

                <template #content>
                    Are you sure you want to delete the organization? Once the organization deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete the organization.

                    <div class="mt-4">
                        <jet-input type="password" class="mt-1 block w-3/4" placeholder="Password"
                                   ref="password"
                                   v-model="form.password"
                                   @keyup.enter="deleteOrganization" />

                        <jet-input-error :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click="deleteOrganization" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Organization
                    </jet-danger-button>
                </template>
            </jet-dialog-modal>
        </template>
    </jet-action-section>
</template>

<script>
import JetActionSection from '@/Jetstream/ActionSection'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    props: ['organization'],
    components: {
        JetActionSection,
        JetDangerButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
    },

    data() {
        return {
            confirmingOrganizationDeletion: false,

            form: this.$inertia.form({
                password: '',
            })
        }
    },

    methods: {
        confirmOrganizationDeletion() {
            this.confirmingOrganizationDeletion = true;

            setTimeout(() => this.$refs.password.focus(), 250)
        },

        deleteOrganization() {
            this.form.delete(route('organizations.destroy', this.organization.id), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.password.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        closeModal() {
            this.confirmingOrganizationDeletion = false

            this.form.reset()
        },
    },
}
</script>
