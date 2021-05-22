<template>
    <div class="dark:bg-gray-800 bg-white text-gray-600 rounded-md shadow-lg dark:text-gray-400 py-2 px-4">
        <div class="text-sm italic" v-text="ago(response.created_at)"></div>
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
