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

                    <jet-section-border />
                </div>
                <div>
                    <job-card v-if="$page.props.ticket.job_card" :job-card="$page.props.ticket.job_card" />
                </div>
                <div class="flex items-center mt-2">
                    <jet-secondary-button-link :href="route('tickets.index')">Back</jet-secondary-button-link>

                    <template v-if="!$page.props.ticket.parent_id">
                        <jet-button-link v-if="! $page.props.ticket.status.final" :href="route('tickets.responses.create', $page.props.ticket.id)" class="ml-2">
                            Respond
                        </jet-button-link>
                        <jet-button-link v-if="$page.props.permissions.canCreateJob" class="ml-2" :href="route('tickets.jobs.create', $page.props.ticket.id)">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M507.73 109.1c-2.24-9.03-13.54-12.09-20.12-5.51l-74.36 74.36-67.88-11.31-11.31-67.88 74.36-74.36c6.62-6.62 3.43-17.9-5.66-20.16-47.38-11.74-99.55.91-136.58 37.93-39.64 39.64-50.55 97.1-34.05 147.2L18.74 402.76c-24.99 24.99-24.99 65.51 0 90.5 24.99 24.99 65.51 24.99 90.5 0l213.21-213.21c50.12 16.71 107.47 5.68 147.37-34.22 37.07-37.07 49.7-89.32 37.91-136.73zM64 472c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z"/></svg>
                            <span class="ml-2">Add Job</span>
                        </jet-button-link>
                        <jet-button-link v-if="$page.props.permissions.canCreateJobCard" class="ml-2" :href="route('tickets.job-card.create', $page.props.ticket.id)">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M139.61 35.5a12 12 0 00-17 0L58.93 98.81l-22.7-22.12a12 12 0 00-17 0L3.53 92.41a12 12 0 000 17l47.59 47.4a12.78 12.78 0 0017.61 0l15.59-15.62L156.52 69a12.09 12.09 0 00.09-17zm0 159.19a12 12 0 00-17 0l-63.68 63.72-22.7-22.1a12 12 0 00-17 0L3.53 252a12 12 0 000 17L51 316.5a12.77 12.77 0 0017.6 0l15.7-15.69 72.2-72.22a12 12 0 00.09-16.9zM64 368c-26.49 0-48.59 21.5-48.59 48S37.53 464 64 464a48 48 0 000-96zm432 16H208a16 16 0 00-16 16v32a16 16 0 0016 16h288a16 16 0 0016-16v-32a16 16 0 00-16-16zm0-320H208a16 16 0 00-16 16v32a16 16 0 0016 16h288a16 16 0 0016-16V80a16 16 0 00-16-16zm0 160H208a16 16 0 00-16 16v32a16 16 0 0016 16h288a16 16 0 0016-16v-32a16 16 0 00-16-16z"/></svg>
                            <span class="ml-2">Add Job Card</span>
                        </jet-button-link>
                    </template>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout"
import JobCard from "@/Pages/Tickets/JobCard";
import ShowTicketForm from '@/Pages/Tickets/ShowTicketForm'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import TicketActivityList from "@/Pages/Tickets/TicketActivityList";
import TicketResponseList from "@/Pages/Tickets/TicketResponseList"
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'
import JetButtonLink from '@/Jetstream/ButtonLink'

export default {
    components: {
        JobCard,
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
    },
}
</script>
