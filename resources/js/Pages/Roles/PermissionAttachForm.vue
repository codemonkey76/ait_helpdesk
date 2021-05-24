<template>
    <jet-form-section>
        <template #title>
            Attach permissions
        </template>
        <template #description>
            Attach all permissions that this role should have
        </template>
        <template #form>
            <div class="flex flex-col md:flex-row justify-between col-span-6 h-72">
                <div class="w-60 flex flex-col">
                    <jet-label>Permission List</jet-label>
                    <stacked-list ref="list"
                                  :data="filteredPermissions"
                                  :grouped="false"
                                  title-field="name"
                                  @selected="addItemSelected"
                                  :selected-item="addItem"
                    />
                </div>
                <div class="flex flex-col justify-center">
                    <jet-button v-if="$page.props.permissions.canAttachPermissions" @click="addPermissionToRole" class="justify-center my-1"
                                :class="{ 'opacity-25': !this.addItem }" :disabled="!this.addItem">Add &gt;
                    </jet-button>
                    <jet-button v-if="$page.props.permissions.canDetachPermissions" @click="removePermissionFromRole" class="justify-center my-1"
                                :class="{ 'opacity-25': !this.removeItem }" :disabled="!this.removeItem">&lt; Remove
                    </jet-button>
                </div>
                <div class="w-60 flex flex-col">
                    <jet-label>Assigned Permissions</jet-label>
                    <stacked-list
                        ref="assigned"
                        :grouped="false"
                        :data="role.permissions"
                        title-field="name"
                        @selected="removeItemSelected"
                        :selected-item="removeItem"
                    ></stacked-list>
                </div>

            </div>
        </template>
    </jet-form-section>
</template>
<script>
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetLabel from '@/Jetstream/Label'
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
    props: ['role', 'permissions'],
    data() {
        return {

            addPermissionToRoleForm: this.$inertia.form({
                _method: 'POST',
                permission_id: this.addItem?.id
            }),
            removePermissionFromRoleForm: this.$inertia.form({
                _method: 'DELETE',
                permission_id: this.removeItem?.id
            }),
            addItem: null,
            removeItem: null
        }
    },
    methods: {
        addItemSelected(item) {
            this.addItem = item
            this.addPermissionToRoleForm.permission_id = item?.id
        },
        removeItemSelected(item) {
            this.removeItem = item
            this.removePermissionFromRoleForm.permission_id = item?.id
        },
        addPermissionToRole() {
            this.addPermissionToRoleForm.post(route('roles.permissions.store', this.role.id), {
                errorBag: 'addPermissionToRole',
                preserveScroll: true,
                onSuccess: () => this.addItem = null
            })
        },
        removePermissionFromRole() {
            this.removePermissionFromRoleForm.delete(route('roles.permissions.destroy', this.role.id), {
                errorBag: 'removePermissionsFromRole',
                preserveScroll: true,
                onSuccess: () => this.removeItem = null
            })
        }
    },
    computed: {
        filteredPermissions() {
            return this.permissions.filter(item => !this.role.permissions.map(p=>p.id).includes(item.id));
        }
    }
}
</script>
