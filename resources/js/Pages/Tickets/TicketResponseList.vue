<template>
<div>
    <div v-for="response in ticket.responses">
        <ticket-response-card  class="my-2" :response="response" />
    </div>
</div>
</template>
<script>
import TicketResponseCard from "@/Pages/Tickets/TicketResponseCard";
export default {
    components: {TicketResponseCard},
    props: ['ticket']
}
</script>
