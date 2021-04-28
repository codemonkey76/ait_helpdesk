<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Show Organization
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <show-organization-form :organization="$page.props.organization"/>

                    <jet-section-border />
                </div>
                <div>
                    <div class="flex">
                        <jet-button @click="showModal">Add Note</jet-button>

                        <note-create-modal
                            :show="creatingNote"
                            :noteable-id="$page.props.organization.id"
                            noteable-type="organization"
                            @close-modal="closeModal">
                        </note-create-modal>

                        <jet-search class="ml-2 flex-1" :search-route="route('organizations.show', $page.props.organization.id)"></jet-search>

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
import ShowOrganizationForm from "./ShowOrganizationForm"
import JetSectionBorder from '@/Jetstream/SectionBorder'
import NotesList from '../Notes/List'
import NoteCreateModal from "@/Pages/Notes/NoteCreateModal";
import JetButton from '@/Jetstream/Button'
import JetButtonLink from "@/Jetstream/ButtonLink"
import JetSearch from "@/Jetstream/Search"
import JetPaginator from "@/Jetstream/Paginator"

export default {
    components: {
        AppLayout,
        ShowOrganizationForm,
        JetSectionBorder,
        NotesList,
        JetButtonLink,
        JetButton,
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
