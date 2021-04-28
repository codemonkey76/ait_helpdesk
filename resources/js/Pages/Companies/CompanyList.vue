<template>
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
                        <tr v-if="!companies.data.length" class="odd:bg-white even:bg-gray-50">
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center italic">Nothing to show</td>
                        </tr>
                        <tr v-for="company in companies.data"
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
                                <a v-show="$page.props.permissions.canEditCompanies" :href="route('companies.edit', company.id)"
                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th scope="col" colspan="6">
                                <jet-paginator :data="companies"></jet-paginator>
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import JetPaginator from '@/Jetstream/Paginator'
export default {
    components: {JetPaginator},
    props: ['companies']
}
</script>
