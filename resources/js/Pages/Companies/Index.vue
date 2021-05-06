<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl dark:text-gray-400 text-gray-800 leading-tight">
                Companies
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex w-full items-center">
                    <jet-button-link :href="route('companies.create')">
                        Create
                    </jet-button-link>
                    <jet-search class="ml-4 w-full" :search-route="route('companies.index')"></jet-search>
                </div>
                <company-list :companies="$page.props.companies" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import JetButtonLink from '@/Jetstream/ButtonLink'
import AppLayout from '@/Layouts/AppLayout'
import JetSearch from '@/Jetstream/Search'
import CompanyList from "@/Pages/Companies/CompanyList";

export default {
    components: {
        CompanyList,
        AppLayout,
        JetButtonLink,
        JetSearch,
    },
}
</script>
