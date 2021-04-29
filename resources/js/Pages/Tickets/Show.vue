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
                    <ticket-response-list :ticket="$page.props.ticket"/>

                    <jet-section-border />
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout"
import ShowTicketForm from '@/Pages/Tickets/ShowTicketForm'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import TicketResponseList from "@/Pages/Tickets/TicketResponseList";

export default {
    components: {
        TicketResponseList,
        AppLayout,
        ShowTicketForm,
        JetSectionBorder,
    },
}
</script>
