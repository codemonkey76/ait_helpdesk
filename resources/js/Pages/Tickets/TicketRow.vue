<template>
    <tr class="odd:bg-white even:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            <a class="text-blue-500 hover:underline" :href="route('tickets.show', ticket.id)" v-text="ticket.id"/>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <user-tag :user="ticket.user" />
        </td>
        <td class="px-6 py-4 text-sm text-gray-500"
            v-text="ticket.subject"/>
        <td class="px-6 py-4 text-sm text-gray-500"
            v-text="ticket.excerpt"/>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
            v-text="ago(ticket.created_at)"/>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
            v-text="ticket.companyAssigned"/>
    </tr>
</template>
<script>
import UserTag from "@/Pages/Users/UserTag";
import moment from "moment";

export default {
    components: {UserTag},
    props: ['ticket'],
    methods: {
        ago(date) {
            return moment(date).fromNow()
        }
    }
}
</script>
