<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Show User
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <show-user-form :user="$page.props.targetUser"/>

                    <jet-section-border />
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout"
import ShowUserForm from '@/Pages/Users/ShowUserForm'
import JetSectionBorder from '@/Jetstream/SectionBorder'

export default {
    components: {
        AppLayout,
        ShowUserForm,
        JetSectionBorder,
    },
}
</script>
