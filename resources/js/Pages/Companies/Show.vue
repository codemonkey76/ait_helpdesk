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
                    <div class="flex">
                        <jet-button-link :href="route('companies.notes.create', $page.props.company.id)">
                            Add Note
                        </jet-button-link>
                        <jet-search class="ml-2 flex-1" :search-route="route('companies.notes.search', $page.props.company.id)"></jet-search>

                    </div>

                    <notes-list :notes="$page.props.notes"/>



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
import NotesList from '../Notes/List'
import JetButtonLink from "@/Jetstream/ButtonLink"
import JetSearch from "@/Jetstream/Search"
import JetPaginator from "@/Jetstream/Paginator"

export default {
    components: {
        AppLayout,
        ShowCompanyForm,
        JetSectionBorder,
        NotesList,
        JetButtonLink,
        JetSearch,
        JetPaginator

    }
}
</script>
