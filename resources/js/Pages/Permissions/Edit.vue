<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit permission
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <edit-permission-form :permission="$page.props.permission" />

                    <jet-section-border />
                </div>
                <div v-show="$page.props.permissions.canDeletePermissions">
                    <delete-permission-form class="mt-10 sm:mt-0" :permission="$page.props.permission"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import DeletePermissionForm from "@/Pages/Permissions/DeletePermissionForm";
import EditPermissionForm from "@/Pages/Permissions/EditPermissionForm";
import JetSectionBorder from '@/Jetstream/SectionBorder'

export default {
    components: {
        DeletePermissionForm,
        EditPermissionForm,
        AppLayout,

        JetSectionBorder
    },
}
</script>
