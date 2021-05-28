<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl dark:text-gray-400 text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="true" class="flex justify-between flex-wrap">
                    <billables :billable-hours="$page.props.stats?.billable_hours"/>
                    <billing-tickets :billable-tickets="$page.props.stats?.billable_tickets"/>
                    <creation-rate :creation-rate="$page.props.stats?.ticket_creation_rate"/>
                    <open-tickets :open-tickets="$page.props.stats?.open_tickets" />
                </div>
                <div class="dark:bg-gray-800 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <welcome/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import Welcome from '@/Jetstream/Welcome'
import AppLayout from '@/Layouts/AppLayout'
import Billables from "@/Pages/Widgets/Billables";
import BillingTickets from "@/Pages/Widgets/BillingTickets";
import CreationRate from "@/Pages/Widgets/CreationRate";
import OpenTickets from "@/Pages/Widgets/OpenTickets";

export default {
    components: {
        OpenTickets,
        CreationRate,
        BillingTickets,
        Billables,
        AppLayout,
        Welcome,
    },
}
</script>
