<template>
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
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                Verified
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                Roles
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="!users.data.length" class="odd:bg-white even:bg-gray-50">
                            <td colspan="5"
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center italic">
                                Nothing to show
                            </td>
                        </tr>
                        <user-row v-for="(user,key) in users.data" :key="key" :user="user" />
                        </tbody>
                        <tfoot>
                        <tr>
                            <th scope="col" colspan="5">
                                <jet-paginator :data="users"></jet-paginator>
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
import JetAvatar from '@/Jetstream/Avatar'
import JetBubble from '@/Jetstream/Bubble'
import JetPaginator from '@/Jetstream/Paginator'
import UserRow from "@/Pages/Users/UserRow";

export default {
    components: {
        UserRow,
        JetPaginator,
        JetBubble,
        JetAvatar
    },
    props: ['users'],
}
</script>
