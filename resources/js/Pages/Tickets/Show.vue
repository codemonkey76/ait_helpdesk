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
                </div>

                <div>
                    <ticket-activity-list :activities="$page.props.activities" />
<!--                    <ticket-response-list :ticket="$page.props.ticket" :responses="$page.props.responses.data"/>-->

                    <jet-section-border />
                </div>
                <div class="flex items-center">
                    <jet-secondary-button-link :href="route('tickets.index')">Back</jet-secondary-button-link>
                    <jet-button-link v-if="! $page.props.ticket.status.final" :href="route('tickets.responses.create', $page.props.ticket.id)" class="ml-2">
                        Respond
                    </jet-button-link>
                    <jet-button-link class="ml-2" v-else href="#" v-if="$page.props.permissions.canChangeTicketStatus">
                        Reopen Ticket
                    </jet-button-link>
                    <jet-button-link v-if="$page.props.permissions.canCreateJob" class="ml-2" :href="route('tickets.jobs.create', $page.props.ticket.id)">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M507.73 109.1c-2.24-9.03-13.54-12.09-20.12-5.51l-74.36 74.36-67.88-11.31-11.31-67.88 74.36-74.36c6.62-6.62 3.43-17.9-5.66-20.16-47.38-11.74-99.55.91-136.58 37.93-39.64 39.64-50.55 97.1-34.05 147.2L18.74 402.76c-24.99 24.99-24.99 65.51 0 90.5 24.99 24.99 65.51 24.99 90.5 0l213.21-213.21c50.12 16.71 107.47 5.68 147.37-34.22 37.07-37.07 49.7-89.32 37.91-136.73zM64 472c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z"/></svg>
                        <span class="ml-2">Add Job</span>
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
import TicketActivityList from "@/Pages/Tickets/TicketActivityList";
import TicketResponseList from "@/Pages/Tickets/TicketResponseList"
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'
import JetButtonLink from '@/Jetstream/ButtonLink'

export default {
    components: {
        TicketActivityList,
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
