<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Response
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <edit-response-form :response="$page.props.response" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import EditResponseForm from './EditResponseForm'

export default {
    components: {
        AppLayout,
        EditResponseForm,
    },
}
</script>
