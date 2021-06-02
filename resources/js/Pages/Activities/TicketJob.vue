<template>
    <div class="dark:bg-gray-800 bg-white text-gray-600 rounded-md shadow-lg dark:text-gray-400 py-2 px-4">
        <div class="text-sm italic" v-text="ago(job.created_at)"></div>
        <div class="mt-2">
            {{ job.user?.userType }}
            <span class="dark:text-gray-200 text-gray-800" v-text="job.userName" />
            added a job

            <div class="mt-2 dark:bg-gray-900 bg-gray-100 py-2 px-4 rounded-md">
                <p class="mb-2">[{{ new Date(job.date).toLocaleDateString('en-AU') }}]</p>
                <div v-html="job.content" />

                <div>
                    Time allocated: {{job.timeSpentString}}
                </div>

            </div>
            <div class="flex mt-2">
                <jet-button-link
                    v-if="canEdit"
                    :href="route('tickets.jobs.edit', [job.ticket_id, job.id])">Edit
                </jet-button-link>
                <jet-danger-button @click="deleting = true" v-if="canDelete" class="ml-2">Delete</jet-danger-button>
                <jet-confirmation-modal :show="deleting" @close="deleting = false">
                    <template #title>
                        Delete Job
                    </template>

                    <template #content>
                        Are you sure you would like to delete job?
                    </template>

                    <template #footer>
                        <jet-secondary-button @click="deleting = false">
                            Cancel
                        </jet-secondary-button>

                        <jet-danger-button class="ml-2" @click="deleteJob"
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
import moment from 'moment'
import JetConfirmationModal from "@/Jetstream/ConfirmationModal"
import JetDangerButton from "@/Jetstream/DangerButton"
import JetSecondaryButton from "@/Jetstream/SecondaryButton"
import JetButtonLink from "@/Jetstream/ButtonLink"
export default {
    props: ['job'],
    components: {
        JetConfirmationModal,
        JetDangerButton,
        JetSecondaryButton,
        JetButtonLink
    },
    methods: {
        ago(date) {
            return new moment(date).fromNow()
        },
        deleteJob() {
            this.deleteForm.delete(route('tickets.jobs.destroy', [this.job.ticket_id, this.job.id]))
        }
    },
    computed: {
        canEdit() {
            return this.$page.props.permissions.canEditAllJobs || (this.$page.props.permissions.canEditOwnJob && this.job.user_id === this.$page.props.user.id)
        },
        canDelete() {
            return this.$page.props.permissions.canDeleteAllJobs || (this.$page.props.permissions.canDeleteOwnJob && this.job.user_id === this.$page.props.user.id)
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
