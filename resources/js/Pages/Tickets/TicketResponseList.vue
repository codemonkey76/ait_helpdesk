<template>
<div>
    <div v-if="!responses || !responses.length" class="text-center dark:text-gray-400 text-gray-500 italic">
        No responses at this time
    </div>
    <div v-else v-for="response in responses">
        <ticket-response-card  class="my-2" :response="response" />
    </div>
</div>
</template>
<script>
import TicketResponseCard from "@/Pages/Tickets/TicketResponseCard";
export default {
    components: {TicketResponseCard},
    props: ['ticket', 'responses']
}
</script>
