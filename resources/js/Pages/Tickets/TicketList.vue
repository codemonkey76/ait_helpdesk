<template>
    <div class="flex flex-col mt-4">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg">
                    <table class="lg:table hidden min-w-full divide-y dark:divide-gray-600 divide-gray-200">
                        <thead class="dark:bg-gray-800 bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium dark:text-gray-400 text-gray-500 uppercase tracking-wider">
                                #<span class="sr-only">Ticket Number</span>
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium dark:text-gray-400 text-gray-500 uppercase tracking-wider">
                                User
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium dark:text-gray-400 text-gray-500 uppercase tracking-wider">
                                Subject
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium dark:text-gray-400 text-gray-500 uppercase tracking-wider">
                                Excerpt
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium dark:text-gray-400 text-gray-500 uppercase tracking-wider">
                                Last Activity
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium dark:text-gray-400 text-gray-500 uppercase tracking-wider">
                                Company
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium dark:text-gray-400 text-gray-500 uppercase tracking-wider">
                                Subscribe
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="!tickets.data.length"
                            class="dark:odd:bg-gray-900 dark:even:bg-gray-800 odd:bg-white even:bg-gray-50">
                            <td colspan="7"
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-gray-400 text-gray-500 text-center italic">
                                Nothing to show
                            </td>
                        </tr>

                        <ticket-row v-for="(ticket,key) in tickets.data" :key="key" :ticket="ticket"/>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th scope="col" colspan="7">
                                <jet-paginator :data="tickets"></jet-paginator>
                            </th>
                        </tr>
                        </tfoot>
                    </table>

                    <card @click.native="openLink(route('tickets.show', ticket.id))" v-for="(ticket,key) in tickets.data"
                          class="block lg:hidden my-2 cursor-pointer" :key="key">
                        <template #header>
                            <h2 class="leading-tight text-xl py-1">#{{ ticket.id }}</h2>
                            <div>{{ago(ticket.updated_at)}}</div>
                        </template>
                        <table>
                            <tr>
                                <th scope="row" class="pr-2">Subject:</th>
                                <td>{{ ticket.subject }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="align-top pr-2">Content:</th>
                                <td>
                                    {{ ticket.content }}
                                </td>
                            </tr>
                        </table>
                        <template #footer>
                            <user-tag :user="ticket.user"/>
                            <div>{{ticket.company_name}}</div>
                        </template>

                    </card>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Card from "@/Jetstream/Card";
import JetPaginator from '@/Jetstream/Paginator'
import TicketRow from "@/Pages/Tickets/TicketRow";
import UserTag from "@/Pages/Users/UserTag";
import moment from 'moment';
export default {
    components: {Card, UserTag, TicketRow, JetPaginator},
    props: ['tickets'],
    methods: {
        ago(date){
            return moment(date).fromNow();
        },
        openLink(route) {
            window.location.href = route
        }
    }
}
</script>
