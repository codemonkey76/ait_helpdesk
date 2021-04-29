<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tickets
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex w-full items-center">
                    <jet-button-link :href="route('tickets.create')">
                        Create
                    </jet-button-link>
                    <jet-search class="ml-4 w-full" :search-route="route('tickets.index')"></jet-search>
                </div>
                <ticket-list :tickets="$page.props.tickets" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import JetButtonLink from '@/Jetstream/ButtonLink'
import AppLayout from '@/Layouts/AppLayout'
import JetSearch from '@/Jetstream/Search'
import TicketList from "@/Pages/Tickets/TicketList";

export default {
    components: {
        TicketList,
        AppLayout,
        JetButtonLink,
        JetSearch,
    },
}
</script>
