<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Job card
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <create-job-card-form :ticket="$page.props.ticket" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import CreateJobCardForm from "@/Pages/JobCards/CreateJobCardForm";

export default {
    components: {
        CreateJobCardForm,
        AppLayout,
    },
}
</script>
