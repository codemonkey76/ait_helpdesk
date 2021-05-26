<template>
    <div class="dark:bg-gray-800 bg-white text-gray-600 rounded-md shadow-lg dark:text-gray-400 py-2 px-4">
        <div class="flex justify-between">
            <div class="text-sm italic" v-text="ago(response.created_at)"></div>
            <div v-if="response.private"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M383.9 308.3l23.9-62.6c4-10.5-3.7-21.7-15-21.7h-58.5c11-18.9 17.8-40.6 17.8-64v-.3c39.2-7.8 64-19.1 64-31.7 0-13.3-27.3-25.1-70.1-33-9.2-32.8-27-65.8-40.6-82.8-9.5-11.9-25.9-15.6-39.5-8.8l-27.6 13.8c-9 4.5-19.6 4.5-28.6 0L182.1 3.4c-13.6-6.8-30-3.1-39.5 8.8-13.5 17-31.4 50-40.6 82.8-42.7 7.9-70 19.7-70 33 0 12.6 24.8 23.9 64 31.7v.3c0 23.4 6.8 45.1 17.8 64H56.3c-11.5 0-19.2 11.7-14.7 22.3l25.8 60.2C27.3 329.8 0 372.7 0 422.4v44.8C0 491.9 20.1 512 44.8 512h358.4c24.7 0 44.8-20.1 44.8-44.8v-44.8c0-48.4-25.8-90.4-64.1-114.1zM176 480l-41.6-192 49.6 32 24 40-32 120zm96 0l-32-120 24-40 49.6-32L272 480zm41.7-298.5c-3.9 11.9-7 24.6-16.5 33.4-10.1 9.3-48 22.4-64-25-2.8-8.4-15.4-8.4-18.3 0-17 50.2-56 32.4-64 25-9.5-8.8-12.7-21.5-16.5-33.4-.8-2.5-6.3-5.7-6.3-5.8v-10.8c28.3 3.6 61 5.8 96 5.8s67.7-2.1 96-5.8v10.8c-.1.1-5.6 3.2-6.4 5.8z"/></svg></div>
        </div>
        <div class="mt-2">
            {{ response.user?.userType }}
            <span class="dark:text-gray-200 text-gray-800" v-text="response.userName"/>
            responded
            <div class="mt-2 dark:bg-gray-900 bg-gray-100 py-2 px-4 rounded-md" v-html="response.content"/>
            <div class="flex mt-2">
                <jet-button-link
                    v-if="canEdit"
                    :href="route('tickets.responses.edit', [response.ticket_id, response.id])">Edit
                </jet-button-link>
                <jet-danger-button @click="deleting = true" v-if="canDelete" class="ml-2">Delete</jet-danger-button>
                <jet-confirmation-modal :show="deleting" @close="deleting = false">
                    <template #title>
                        Delete Response
                    </template>

                    <template #content>
                        Are you sure you would like to delete response?
                    </template>

                    <template #footer>
                        <jet-secondary-button @click="deleting = false">
                            Cancel
                        </jet-secondary-button>

                        <jet-danger-button class="ml-2" @click="deleteResponse"
                                           :class="{ 'opacity-25': deleteForm.processing }"
                                           :disabled="deleteForm.processing">
                            Delete
                        </jet-danger-button>
                    </template>
                </jet-confirmation-modal>
            </div>
        </div>
    </div>
</template>
<script>

import JetButtonLink from "@/Jetstream/ButtonLink";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
import JetDangerButton from "@/Jetstream/DangerButton";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import moment from 'moment'

export default {
    components: {JetConfirmationModal, JetSecondaryButton, JetDangerButton, JetButtonLink},
    props: ['response'],
    methods: {
        ago(date) {
            return new moment(date).fromNow()
        },
        deleteResponse() {
            this.deleteForm.delete(route('tickets.responses.destroy', [this.response.ticket_id, this.response.id]))
        }
    },
    computed: {
        canEdit() {
            return this.$page.props.permissions.canEditAllResponses || (this.$page.props.permissions.canEditOwnResponse && this.response.user_id === this.$page.props.user.id)
        },
        canDelete() {
            return this.$page.props.permissions.canDeleteAllResponses || (this.$page.props.permissions.canDeleteOwnResponse && this.response.user_id === this.$page.props.user.id)
        }
    },
    data() {
        return {
            deleting: false,
            deleteForm: this.$inertia.form({
                _method: 'DELETE',
            })
        }
    },
}
</script>
