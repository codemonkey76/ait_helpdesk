<template>
    <jet-form-section>
        <template #title>
            Assign roles
        </template>
        <template #description>
            Assign roles that user needs permissions for
        </template>
        <template #form>
            <div class="flex flex-col md:flex-row justify-between col-span-6 h-72">
                <div class="w-60 flex flex-col">
                    <jet-label>Role List</jet-label>
                    <stacked-list ref="list"
                                  :data="filteredRoles"
                                  :grouped="false"
                                  title-field="name"
                                  @selected="addRoleSelected"
                                  :selected-item="addItem"
                    />
                </div>
                <div class="flex flex-col justify-center">
                    <jet-button @click="addRoleToUser" class="justify-center my-1" :class="{ 'opacity-25': !this.addItem }" :disabled="!this.addItem">Add &gt;</jet-button>
                    <jet-button @click="removeRoleFromUser" class="justify-center my-1" :class="{ 'opacity-25': !this.removeItem }" :disabled="!this.removeItem">&lt; Remove</jet-button>
                </div>
                <div class="w-60 flex flex-col">
                    <jet-label>Assigned roles</jet-label>
                    <stacked-list
                        ref="assigned"
                        :grouped="false"
                        :data="user.roles"
                        title-field="name"
                        @selected="removeRoleSelected"
                        :selected-item="removeItem"
                    ></stacked-list>
                </div>
            </div>
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
        JetLabel,
        JetButton,
        JetSecondaryButtonLink
    },
    props: ['user', 'roles'],
    data() {
        return {
            addRoleToUserForm: this.$inertia.form({
                _method: 'POST',
                role_id: this.addItem?.id
            }),
            removeRoleFromUserForm: this.$inertia.form({
                _method: 'DELETE',
                role_id: this.removeItem?.id
            }),
            addItem: null,
            removeItem: null
        }
    },
    methods: {
        addRoleSelected(role) {
            this.addItem = role
            this.addRoleToUserForm.role_id = role?.id
        },
        removeRoleSelected(role) {
            this.removeItem = role
            this.removeRoleFromUserForm.role_id = role?.id
        },
        addRoleToUser() {
            this.addRoleToUserForm.post(route('users.roles.store', this.user.id),{
                errorBag: 'addRoleToUser',
                preserveScroll: true,
                onSuccess: () => this.addItem = null
            })
        },
        removeRoleFromUser() {
            this.removeRoleFromUserForm.delete(route('users.roles.destroy', this.user.id),{
                errorBag: 'removeRoleFromUser',
                preserveScroll: true,
                onSuccess: () => this.removeItem = null
            })
        }
    },
    computed: {
        filteredRoles() {
            // filter out roles already assigned to the user
            return this.roles.filter((element) => {
                return !this.user.roles.find(role => role.id === element.id)
            })
        }
    }
}
</script>
