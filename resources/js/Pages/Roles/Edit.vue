<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit role
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <edit-role-form :role="$page.props.role" />

                    <jet-section-border />
                </div>
                <div v-if="$page.props.permissions.canAttachPermissions || $page.props.permissions.canDetachPermissions">
                    <permission-attach-form :role="$page.props.role" :permissions="$page.props.permission_list"/>
                </div>
                <div v-show="$page.props.permissions.canDeleteRoles">
                    <delete-role-form class="mt-10 sm:mt-0" :role="$page.props.role" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import DeleteRoleForm from "@/Pages/Roles/DeleteRoleForm";
import EditRoleForm from "@/Pages/Roles/EditRoleForm";
import PermissionAttachForm from "@/Pages/Roles/PermissionAttachForm";
export default {
    components: {
        EditRoleForm,
        DeleteRoleForm,
        AppLayout,
        JetSectionBorder,
        PermissionAttachForm
    },
}
</script>
