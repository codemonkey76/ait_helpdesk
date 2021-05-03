<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Show ticket
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <show-ticket-form :ticket="$page.props.ticket"/>

                    <jet-section-border />
                </div>

                <div>
                    <ticket-response-list :ticket="$page.props.ticket" :responses="$page.props.responses.data"/>

                    <jet-section-border />
                </div>
                <div>
                    <jet-button-link v-if="! $page.props.ticket.status.final" :href="route('tickets.responses.create', $page.props.ticket.id)">
                        Respond
                    </jet-button-link>
                    <jet-button-link class="ml-2" v-else v-if="$page.props.permissions.canChangeTicketStatus" href="#">
                        Reopen Ticket
                    </jet-button-link>

                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout"
import ShowTicketForm from '@/Pages/Tickets/ShowTicketForm'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import TicketResponseList from "@/Pages/Tickets/TicketResponseList"
import JetButtonLink from '@/Jetstream/ButtonLink'

export default {
    components: {
        TicketResponseList,
        AppLayout,
        ShowTicketForm,
        JetSectionBorder,
        JetButtonLink
    },
}
</script>
