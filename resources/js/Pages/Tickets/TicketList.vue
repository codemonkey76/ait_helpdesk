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
                                #<span class="sr-only">Ticket Number</span>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subject
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Excerpt
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Age
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Company
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="!tickets.data.length" class="odd:bg-white even:bg-gray-50">
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center italic">Nothing to show</td>
                        </tr>
                        <ticket-row v-for="(ticket,key) in tickets.data" :key="key" :ticket="ticket" />
                        </tbody>
                        <tfoot>
                        <tr>
                            <th scope="col" colspan="6">
                                <jet-paginator :data="tickets"></jet-paginator>
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
import TicketRow from "@/Pages/Tickets/TicketRow";

export default {
    components: {TicketRow, JetPaginator},
    props: ['tickets'],
}
</script>
