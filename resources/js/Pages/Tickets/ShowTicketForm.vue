<template>
    <div class="dark:bg-gray-800 bg-white pt-16 pb-16 px-4 sm:px-6 lg:px-8 rounded-md shadow-lg">
        <div class="relative max-w-lg mx-auto divide-y-2 dark:divide-gray-600 divide-gray-200 lg:max-w-7xl">
            <div>
                <div class="absolute -mt-12 right-0">
                    <div class="flex">
                        <jet-button v-if="$page.props.permissions.canChangeTicketStatus" @click="updatingStatus = true">Change Status</jet-button>
                        <jet-button-link v-if="$page.props.permissions.canEditTicket" class="mx-2" :href="route('tickets.edit', ticket.id)">Edit Ticket</jet-button-link>
                        <status-indicator :status_id="ticket.status_id" :options="$page.props.statusOptions" />
                    </div>

                    <jet-confirmation-modal :show="updatingStatus" @close="updatingStatus = false">
                        <template #title>
                            Change Status
                        </template>

                        <template #content>
                            Changing ticket status?
                            <div class="col-span-6 mt-4">
                                <jet-label for="status_id" value="Status" />
                                <jet-select
                                    id="status_id"
                                    :options="$page.props.statusOptions"
                                    v-model="form.status_id">
                                </jet-select>
                                <span class="dark:text-gray-400 text-gray-500 ml-2" v-text="statusDescription(form.status_id)" />
                                <jet-input-error :message="form.errors.status_id" class="mt-2" />
                            </div>
                        </template>


                        <template #footer>
                            <jet-secondary-button @click="deleting = false">
                                Cancel
                            </jet-secondary-button>

                            <jet-danger-button class="ml-2" @click="changeStatus"
                                               :class="{ 'opacity-25': form.processing }"
                                               :disabled="form.processing">
                                Change
                            </jet-danger-button>
                        </template>
                    </jet-confirmation-modal>
                </div>
                <h2 class="text-3xl tracking-tight font-extrabold dark:text-gray-200 text-gray-900 sm:text-4xl">
                    Ticket #<span v-text="ticket.id"></span>
                </h2>
                <p class="mt-3 text-xl  dark:text-gray-400 text-gray-500 sm:mt-4" v-text="ticket.subject"/>
            </div>
            <div class="mt-4 pt-12">
                <div>
                    <a href="#" class="block mt-4">
                        <div class="mt-2 dark:bg-gray-900 py-2 px-4 rounded-md dark:text-gray-400" v-html="ticket.content" />
                    </a>
                    <div class="mt-6 flex items-center">
                        <div class="flex-shrink-0">
                            <a href="#">
                                <span class="sr-only" v-text="ticket.user?.name" />
                                <img class="h-10 w-10 rounded-full"
                                     :src="ticket.user.profile_photo_url"
                                     alt="">
                            </a>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium dark:text-gray-200 text-gray-900" v-text="ticket.user?.name" />
                            <div class="flex space-x-1 text-sm dark:text-gray-400 text-gray-500">
                                <span v-text="ago(ticket.created_at)" />
                                <span aria-hidden="true">&middot; Read: </span>
                                <span v-text="readText" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import JetLabel from "@/Jetstream/Label"
import JetSelect from "@/Jetstream/Select"
import JetInputError from "@/Jetstream/InputError"
import JetDangerButton from "@/Jetstream/DangerButton"
import JetSecondaryButton from "@/Jetstream/SecondaryButton"
import JetButton from "@/Jetstream/Button"
import JetButtonLink from "@/Jetstream/ButtonLink"
import JetConfirmationModal from "@/Jetstream/ConfirmationModal"
import StatusIndicator from "@/Jetstream/StatusIndicator"
import moment from "moment";

export default {
    components: {
        JetLabel,
        JetSelect,
        JetInputError,
        JetDangerButton,
        JetSecondaryButton,
        JetButton,
        JetButtonLink,
        StatusIndicator,
        JetConfirmationModal
    },
    props: ['ticket'],
    data() {
        return {
            updatingStatus: false,

            form: this.$inertia.form({
                _method: 'PATCH',
                status_id: this.ticket.status_id
            })
        }
    },
    methods: {
        ago(date) {
            return moment(date).fromNow()
        },
        statusDescription(id) {
            return this.$page.props.statusOptions.find(x => parseInt(x.id) === parseInt(id))?.description
        },
        changeStatus() {
            this.updatingStatus = false
            this.form.patch(route('tickets.status.update', this.ticket.id))
        }
    },
    computed: {
        readText() {
            let reader = this.ticket.readers?.find(x => x.id === this.$page.props.user.id);
            return (this.ticket.readers?.agent_read_at) ? moment(this.ticket.agent_read_at).fromNow() : 'unread'
        }
    }
}
</script>
