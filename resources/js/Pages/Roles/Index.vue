<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl dark:text-gray-400 text-gray-800 leading-tight">
                Roles
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex w-full items-center">
                    <jet-button-link v-if="$page.props.permissions.canCreateRoles" :href="route('roles.create')">
                        Create
                    </jet-button-link>
                </div>
                <role-list :roles="$page.props.roles" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import JetButtonLink from '@/Jetstream/ButtonLink'
import AppLayout from '@/Layouts/AppLayout'
import RoleList from "@/Pages/Roles/RoleList";

export default {
    components: {
        RoleList,
        AppLayout,
        JetButtonLink,
    },
}
</script>
