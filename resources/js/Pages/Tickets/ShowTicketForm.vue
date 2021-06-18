<template>
    <div class="dark:bg-gray-800 bg-white pt-16 pb-16 px-4 sm:px-6 lg:px-8 rounded-md shadow-lg">
        <div class="relative max-w-lg mx-auto divide-y-2 dark:divide-gray-600 divide-gray-200 lg:max-w-7xl">
            <div>
                <div class="absolute -mt-12 right-0">
                    <div class="flex items-center space-x-2">
                        <div v-if="ticket.agent" class="dark:text-gray-400 space-x-1">
                            <span>Agent assigned:</span> 
                            <user-tag :user="ticket.agent" />
                        </div>
                        <jet-button v-if="$page.props.permissions.canAssignAgent" @click="updatingAgent = true">Assign Agent</jet-button>
                        <jet-button v-if="$page.props.permissions.canChangeTicketStatus" @click="updatingStatus = true">Change Status</jet-button>
                        <jet-button-link v-if="$page.props.permissions.canEditTicket" :href="route('tickets.edit', ticket.id)">Edit Ticket</jet-button-link>
                        <status-indicator :status_id="ticket.status_id" :options="$page.props.statusOptions" />
                    </div>

                    <jet-confirmation-modal :show="updatingAgent" @close="updatingAgent = false">
                        <template #title>
                            Assign Agent
                        </template>

                        <template #content>
                            Assign agent to ticket?
                            <div class="col-span-6 mt-4">
                                <jet-label for="agent_id" value="Agent" />
                                <jet-select
                                    id="agent_id"
                                    :options="$page.props.agentOptions"
                                    v-model="agentForm.agent_id">
                                    <template v-slot:none-selected>
                                        <option value="">No agent assigned</option>
                                    </template>
                                </jet-select>

                                <jet-input-error :message="form.errors.agent_id" class="mt-2" />
                            </div>
                        </template>


                        <template #footer>
                            <jet-secondary-button @click="updatingAgent = false">
                                Cancel
                            </jet-secondary-button>

                            <jet-danger-button class="ml-2" @click="changeAgent"
                                               :class="{ 'opacity-25': agentForm.processing }"
                                               :disabled="agentForm.processing">
                                Change
                            </jet-danger-button>
                        </template>
                    </jet-confirmation-modal>

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
import UserTag from "@/Pages/Users/UserTag";
import moment from "moment";

export default {
    components: {
        UserTag,
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
            updatingAgent: false,

            agentForm: this.$inertia.form({
                _method: 'PATCH',
                agent_id: this.ticket.assigned_agent_id ?? ""
            }),
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
            this.form.patch(route('tickets.status.update', this.ticket.id), {
                preserveScroll: true,
                onSuccess: () => (this.updatingStatus = false),
            })


        },
        changeAgent() {
            this.updatingAgent = false
            this.agentForm.patch(route('tickets.agent.update', this.ticket.id), {
                preserveScroll: true,
                onSuccess: () => (this.updatingAgent = false),
            })
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
