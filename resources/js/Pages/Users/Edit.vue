<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit User
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <edit-user-form :user="$page.props.targetUser"/>

                    <jet-section-border />
                </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import EditUserForm from '@/Pages/Users/EditUserForm'


export default {
    components: {
        AppLayout,
        EditUserForm,
        JetSectionBorder,

    },
}
</script>
