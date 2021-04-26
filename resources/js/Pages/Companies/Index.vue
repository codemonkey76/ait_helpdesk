<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex w-full items-center">
                    <button-link :href="route('companies.create')">
                        Create
                    </button-link>
                    <jet-search class="ml-4 w-full" :search-route="route('companies.search')"></jet-search>
                </div>
                <!-- This example requires Tailwind CSS v2.0+ -->
                <div class="flex flex-col mt-4">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Phone
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Suburb
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            State
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Organization
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="company in $page.props.companies.data"
                                        class="odd:bg-white even:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <a class="text-blue-500 hover:underline" :href="route('companies.show', company.id)" v-text="company.name"/>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                            v-text="company.phone"/>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                            v-text="company.suburb"/>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                            v-text="company.state"/>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                            v-text="company.organizationName"/>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a :href="route('companies.edit', company.id)"
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
import ButtonLink from '@/Jetstream/ButtonLink'
import AppLayout from '@/Layouts/AppLayout'
import JetSearch from '@/Jetstream/Search'

export default {
    components: {
        AppLayout,
        ButtonLink,
        JetSearch
    },
}
</script>
