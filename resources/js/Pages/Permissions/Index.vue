<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl dark:text-gray-400 text-gray-800 leading-tight">
                Permissions
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex w-full items-center">
                    <jet-button-link v-if="$page.props.permissions.canCreatePermissions" :href="route('permissions.create')">
                        Create
                    </jet-button-link>
                </div>
                <permission-list :permissions="$page.props.permission_list" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import JetButtonLink from '@/Jetstream/ButtonLink'
import AppLayout from '@/Layouts/AppLayout'
import PermissionList from "@/Pages/Permissions/PermissionList";

export default {
    components: {
        PermissionList,
        AppLayout,
        JetButtonLink,
    },
}
</script>
