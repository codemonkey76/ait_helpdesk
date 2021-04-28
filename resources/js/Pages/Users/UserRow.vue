<template>
    <tr class="odd:bg-white even:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            <div class="flex items-center">
                <jet-avatar :src="user.profile_photo_url" :alt="user.name"/>
                <a class="ml-2 text-blue-500 hover:underline" :href="route('users.show', user.id)"
                   v-text="user.name"/>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
            v-text="user.email"/>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <div class="flex justify-center">
                <jet-bubble v-show="user.email_verified_at">Verified</jet-bubble>
                <jet-bubble type="danger" v-show="!user.email_verified_at">Not Verified</jet-bubble>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <div class="flex justify-center">
                <jet-bubble v-for="(role,key) in user.roles" :key="key" v-text="role.name"/>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

            <a v-show="$page.props.permissions.canEditUsers" :href="route('users.edit', user.id)"
               class="text-blue-500 hover:underline">Edit</a>
            <a v-show="$page.props.permissions.canDeleteUsers" href="#" @click="confirmUserDeletion"
               class="ml-2 text-red-600 hover:underline">Delete</a>

            <jet-confirmation-modal :show="confirmingUserDeletion" @close="confirmingUserDeletion = false">
                <template #title>
                    Delete User
                </template>

                <template #content>
                    Are you sure you want to delete this user? Once a user is deleted, it cannot be recovered.
                </template>

                <template #footer>
                    <jet-secondary-button @click="confirmingUserDeletion = false">
                        Cancel
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click="deleteUser" :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing">
                        Delete User
                    </jet-danger-button>
                </template>
            </jet-confirmation-modal>
        </td>

    </tr>
</template>
<script>
import JetAvatar from '@/Jetstream/Avatar'
import JetBubble from '@/Jetstream/Bubble'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    components: {
        JetBubble,
        JetAvatar,
        JetConfirmationModal,
        JetSecondaryButton,
        JetDangerButton
    },
    props: ['user'],
    data() {
        return {
            confirmingUserDeletion: false,
            form: this.$inertia.form({
                _method: 'DELETE'
            })
        }
    },
    methods: {
        confirmUserDeletion() {
            if (!this.user.email_verified_at) {
                this.deleteUser()
                return
            }
            this.confirmingUserDeletion = true
        },
        closeModal() {
          this.confirmingUserDeletion = false
        },
        deleteUser() {
            this.form.delete(route('users.destroy', this.user.id), {
                errorBag: 'deleteUser',
                preserveScroll: true,
                onSuccess: () => this.closeModal()
            });
        }
    }
}
</script>
