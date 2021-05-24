<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-search class="w-full" :search-route="route('users.index')" :search="$page.props.q"></jet-search>

                <user-list :users="$page.props.users" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import JetSearch from '@/Jetstream/Search'
import AppLayout from '@/Layouts/AppLayout'
import JetInput from '@/Jetstream/Input'
import JetFormSection from '@/Jetstream/FormSection'
import UserList from "@/Pages/Users/UserList";

export default {
    components: {
        UserList,
        AppLayout,
        JetSearch,
        JetInput,
        JetFormSection
    },
}
</script>
