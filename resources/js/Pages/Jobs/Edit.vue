<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Job
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <edit-job-form :ticket="$page.props.ticket" :job="$page.props.job" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import EditJobForm from "@/Pages/Jobs/EditJobForm";
import JetSectionBorder from '@/Jetstream/SectionBorder'

export default {
    components: {
        EditJobForm,
        AppLayout,
        JetSectionBorder
    },
}
</script>
