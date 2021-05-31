<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit User
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <edit-user-form :user="$page.props.targetUser"/>

                    <jet-section-border />
                </div>
                <div class="md:block hidden">
                    <assign-companies-form :companies="$page.props.companies" :user="$page.props.targetUser" />
                    <jet-section-border />
                </div>
                <div class="md:block hidden">
                    <assign-roles-form :user="$page.props.targetUser" :roles="$page.props.availableRoles"/>
                    <jet-section-border />
                </div>
                <div class="md:block hidden" />
                    <communication-preferences-form :user="$page.props.targetUser" />

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import CommunicationPreferencesForm from '@/Pages/Users/CommunicationPreferencesForm'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import AssignCompaniesForm from "@/Pages/Users/AssignCompaniesForm";
import AssignRolesForm from "@/Pages/Users/AssignRolesForm";
import EditUserForm from '@/Pages/Users/EditUserForm'


export default {
    components: {
        AssignRolesForm,
        AssignCompaniesForm,
        AppLayout,
        CommunicationPreferencesForm,
        EditUserForm,
        JetSectionBorder,
    },
}
</script>
