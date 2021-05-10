<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl dark:text-gray-400 text-gray-800 leading-tight">
                Show ticket
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 px-2 sm:px-6 lg:px-8">
                <div>
                    <show-ticket-form :ticket="$page.props.ticket"/>

                    <jet-section-border />
                </div>

                <div>
                    <ticket-response-list :ticket="$page.props.ticket" :responses="$page.props.responses.data"/>

                    <jet-section-border />
                </div>
                <div>
                    <jet-secondary-button-link :href="route('tickets.index')">Back</jet-secondary-button-link>
                    <jet-button-link v-if="! $page.props.ticket.status.final" :href="route('tickets.responses.create', $page.props.ticket.id)" class="ml-2">
                        Respond
                    </jet-button-link>
                    <jet-button-link class="ml-2" v-else href="#" v-if="$page.props.permissions.canChangeTicketStatus">
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
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'
import JetButtonLink from '@/Jetstream/ButtonLink'

export default {
    components: {
        TicketResponseList,
        AppLayout,
        ShowTicketForm,
        JetSectionBorder,
        JetButtonLink,
        JetSecondaryButtonLink
    },
    methods: {
        reopenTicket() {
            let form = this.$inertia.form({
                'status_id': 1
            })
            form.patch(route('tickets.status.update', this.$page.props.ticket.id),{
                errorBag: 'updateStatus',
                preserveScroll: true
            })
        }
    }
}
</script>
