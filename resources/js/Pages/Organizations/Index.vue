<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl dark:text-gray-400 text-gray-800 leading-tight">
                Organizations
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex w-full items-center">
                    <jet-button-link :href="route('organizations.create')">
                        Create
                    </jet-button-link>
                    <jet-search class="ml-4 w-full" :search-route="route('organizations.index')" :search="$page.props.q"></jet-search>
                </div>
                <organization-list :organizations="$page.props.organizations" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import JetButtonLink from '@/Jetstream/ButtonLink'
import JetSearch from '@/Jetstream/Search'
import AppLayout from '@/Layouts/AppLayout'
import JetInput from '@/Jetstream/Input'
import JetFormSection from '@/Jetstream/FormSection'
import OrganizationList from "@/Pages/Organizations/OrganizationList";
export default {
    components: {
        OrganizationList,
        AppLayout,
        JetButtonLink,
        JetSearch,
        JetInput,
        JetFormSection
    },
}
</script>
