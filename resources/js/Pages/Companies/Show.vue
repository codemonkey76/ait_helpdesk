<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl dark:text-gray-400 text-gray-800 leading-tight">
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
                        <jet-button @click="showModal">Add Note</jet-button>

                        <note-create-modal
                            :show="creatingNote"
                            :noteable-id="$page.props.company.id"
                            noteable-type="company"
                            @close-modal="closeModal">
                        </note-create-modal>
                        <jet-search class="ml-2 flex-1" :search-route="route('companies.show', $page.props.company.id)"></jet-search>

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
import JetButton from '@/Jetstream/Button'
import JetSearch from "@/Jetstream/Search"
import JetPaginator from "@/Jetstream/Paginator"
import NoteCreateModal from '../Notes/NoteCreateModal'

export default {
    components: {
        AppLayout,
        ShowCompanyForm,
        JetSectionBorder,
        NotesList,
        JetButton,
        JetButtonLink,
        JetSearch,
        JetPaginator,
        NoteCreateModal
    },
    data() {
        return {
            creatingNote: false
        }
    },
    methods: {
        showModal() {
            this.creatingNote = true;
        },
        closeModal() {
            this.creatingNote = false;
        }
    }
}
</script>
