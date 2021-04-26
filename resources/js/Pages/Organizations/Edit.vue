<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Organization
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <edit-organization-form :organization="$page.props.organization"/>

                    <jet-section-border />
                </div>

                <div>
                    <delete-organization-form class="mt-10 sm:mt-0" :organization="$page.props.organization"/>

                    <jet-section-border />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import EditOrganizationForm from './EditOrganizationForm'
import DeleteOrganizationForm from "./DeleteOrganizationForm";

export default {
    components: {
        AppLayout,
        EditOrganizationForm,
        JetSectionBorder,
        DeleteOrganizationForm
    },
}
</script>
