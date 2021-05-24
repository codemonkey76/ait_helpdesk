<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create permission
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <create-permission-form />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import CreatePermissionForm from "@/Pages/Permissions/CreatePermissionForm";

export default {
    components: {
        CreatePermissionForm,
        AppLayout,
    },
}
</script>
