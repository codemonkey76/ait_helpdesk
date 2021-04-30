<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Ticket
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <create-response-form :ticket="$page.props.ticket" :status="$page.props.statusOptions"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import CreateResponseForm from './CreateResponseForm'

export default {
    components: {
        AppLayout,
        CreateResponseForm,
    },
}
</script>
