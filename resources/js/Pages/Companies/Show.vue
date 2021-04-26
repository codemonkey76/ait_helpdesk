<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Show company
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <show-company-form :company="$page.props.company"/>

                    <jet-section-border />
                </div>
                <div>
                    <notes-list  class="mt-10 sm:mt-0" :company="$page.props.company.notes"/>

                    <jet-section-border />
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout"
import ShowCompanyForm from "./ShowCompanyForm"
import JetSectionBorder from '@/Jetstream/SectionBorder'
import NotesList from './NotesList'
export default {
    components: {
        AppLayout,
        ShowCompanyForm,
        JetSectionBorder,
        NotesList
    }
}
</script>
