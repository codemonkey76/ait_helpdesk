<template>
    <div class="flex flex-col mt-4">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden sm:rounded-lg">
                    <table class="min-w-full divide-y dark:divide-gray-600 divide-gray-200">
                        <thead class="dark:bg-gray-800 bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium dark:text-gray-400 text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium dark:text-gray-400 text-gray-500 uppercase tracking-wider">
                                Subject
                            </th>
                            <th scope="col"
                                class="hidden lg:table-cell px-6 py-3 text-left text-xs font-medium dark:text-gray-400 text-gray-500 uppercase tracking-wider">
                                Content
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="!bugs.data.length" class="dark:odd:bg-gray-900 dark:even:bg-gray-800 odd:bg-white even:bg-gray-50">
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-gray-400 text-gray-500 text-center italic">Nothing to show</td>
                        </tr>
                        <tr v-for="bug in bugs.data"
                            class="dark:odd:bg-gray-700 dark:even:bg-gray-800 odd:bg-white even:bg-gray-50">
                            <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-sm dark:text-gray-300 text-gray-500"
                                v-text="bug.userName"/>
                            <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-gray-300 text-gray-500"
                                v-text="bug.subject"/>
                            <td class="hidden lg:table-cell px-6 py-4 whitespace-nowrap text-sm dark:text-gray-300 text-gray-500"
                                v-html="bug.content"/>

                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th scope="col" colspan="6">
                                <jet-paginator :data="bugs"></jet-paginator>
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
    props: ['bugs']
}
</script>
