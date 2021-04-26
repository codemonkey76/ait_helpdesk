<template>
    <jet-action-section>
        <template #title>
            Delete Company
        </template>

        <template #description>
            Permanently delete the company.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once the company is deleted, all of its resources and data will be permanently deleted. Before deleting the company, please download any data or information that you wish to retain.
            </div>

            <div class="mt-5">
                <jet-danger-button @click="confirmCompanyDeletion">
                    Delete Company
                </jet-danger-button>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <jet-dialog-modal :show="confirmingCompanyDeletion" @close="closeModal">
                <template #title>
                    Delete Company
                </template>

                <template #content>
                    Are you sure you want to delete the company? Once the company is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete the company.

                    <div class="mt-4">
                        <jet-input type="password" class="mt-1 block w-3/4" placeholder="Password"
                                   ref="password"
                                   v-model="form.password"
                                   @keyup.enter="deleteCompany" />

                        <jet-input-error :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click="deleteCompany" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Company
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
    components: {
        JetActionSection,
        JetDangerButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
    },
    props: ['company'],

    data() {
        return {
            confirmingCompanyDeletion: false,

            form: this.$inertia.form({
                password: '',
            })
        }
    },

    methods: {
        confirmCompanyDeletion() {
            this.confirmingCompanyDeletion = true;

            setTimeout(() => this.$refs.password.focus(), 250)
        },

        deleteCompany() {
            this.form.delete(route('companies.destroy', this.company.id), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.password.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        closeModal() {
            this.confirmingCompanyDeletion = false

            this.form.reset()
        },
    },
}
</script>
