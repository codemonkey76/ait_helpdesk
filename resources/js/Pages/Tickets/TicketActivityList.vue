<template>
    <div>
        <h2 class="text-3xl tracking-tight font-extrabold dark:text-gray-200 text-gray-900 sm:text-4xl mt-8 ">
            Ticket Activity
        </h2>
        <jet-section-border />
        <div v-if="!activities || !activities.total" class="text-center dark:text-gray-400 text-gray-500 italic">
            No activity at this time
        </div>
        <div v-else v-for="activity in activities.data">
            <ticket-status-changed v-if="activity.subject_type==='status_change'" :status-change="activity.subject" class="my-2"/>
            <ticket-response v-if="activity.subject_type==='response'" :response="activity.subject" class="my-2"/>
            <ticket-job v-if="activity.subject_type==='job'" :job="activity.subject" class="my-2"/>
        </div>
        <paginator :data="activities" />

    </div>
</template>

<script>
import JetSectionBorder from '@/Jetstream/SectionBorder'
import Paginator from "@/Jetstream/Paginator";
import TicketResponse from "@/Pages/Activities/TicketResponse";
import TicketJob from "@/Pages/Activities/TicketJob";
import TicketStatusChanged from "@/Pages/Activities/TicketStatusChanged";
import TicketResponseCard from "@/Pages/Tickets/TicketResponseCard";
export default {
    components: {Paginator, TicketResponse, TicketResponseCard, TicketStatusChanged, TicketJob, JetSectionBorder},
    props: ['activities']
}
</script>
