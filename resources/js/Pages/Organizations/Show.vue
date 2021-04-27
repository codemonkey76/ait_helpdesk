    <template>
        <app-layout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Company View
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex w-full items-center">
                        <button-link :href="route('organizations.create')">
                            Create
                        </button-link>
                        <jet-search class="ml-4 w-full" :search-route="route('organizations.search')"></jet-search>
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
                                                Head Office
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="organization in $page.props.organizations.data"
                                            class="odd:bg-white even:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <a class="text-blue-500 hover:underline" :href="route('organizations.show', organization.id)" v-text="organization.name" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                                v-text="organization.headOfficeName"/>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a :href="route('organizations.edit', organization.id)"
                                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th scope="col" colspan="3">
                                                <jet-paginator :data="$page.props.organizations"></jet-paginator>
                                            </th>
                                        </tr>
                                        </tfoot>
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
        import JetPaginator from '@/Jetstream/Paginator'
        import JetSearch from '@/Jetstream/Search'
        import AppLayout from '@/Layouts/AppLayout'
        import JetInput from '@/Jetstream/Input'
        import JetFormSection from '@/Jetstream/FormSection'
        export default {
            components: {
                AppLayout,
                ButtonLink,
                JetPaginator,
                JetSearch,
                JetInput,
                JetFormSection
            },
        }
    </script>
