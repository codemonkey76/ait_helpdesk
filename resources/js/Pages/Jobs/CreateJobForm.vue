<template>
    <jet-form-section @submitted="createJob">
        <template #title>
            Job Details
        </template>

        <template #description>
            Create a new job.
        </template>

        <template #form>

            <div class="col-span-6">
                <jet-label for="content" value="Content"/>
                <wysiwyg id="content" v-model="form.content" :attachment-path="attachmentPath" />
                <jet-input-error :message="form.errors.content" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <jet-label for="user_id" value="Agent"/>
                <jet-select
                    :options="$page.props.agentOptions"
                    v-model="form.user_id">
                    <template v-if="!default_agent" #none-selected>
                        <option :value="null">None selected</option>
                    </template>
                </jet-select>
                <jet-input-error :message="form.errors.user_id" class="mt-2"/>
            </div>


            <div class="col-span-6">
                <jet-label for="time_spent" value="Time Spent"/>
                <jet-select
                    :options="$page.props.timeOptions"
                    v-model="form.time_spent">
                    <template v-if="!default_time" #none-selected>
                        <option :value="null">None selected</option>
                    </template>
                </jet-select>
                <jet-input-error :message="form.errors.time_spent" class="mt-2"/>
            </div>
            <div class="col-span-6">
                <jet-label for="date" value="Date"/>
                <jet-input type="date" id="date" v-model="form.date"></jet-input>
                <jet-input-error :message="form.errors.date" class="mt-2"/>
            </div>

            <jet-input-error v-for="error in form.errors" :message="error" class="mt-2"/>


        </template>

        <template #actions>
            <jet-secondary-button-link :href="route('tickets.show', ticket.id)">Cancel</jet-secondary-button-link>
            <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import DatePicker from "@/Jetstream/DatePicker";
import Editor from "@/Jetstream/Editor";
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetSelect from '@/Jetstream/Select'
import JetText from '@/Jetstream/TextArea'
import Wysiwyg from "../../Components/Wysiwyg";

export default {
    components: {
        Wysiwyg,
        Editor,
        DatePicker,
        JetButton,
        JetSecondaryButtonLink,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSelect,
        JetText
    },
    props: ['ticket'],
    data() {
        return {
            form: this.$inertia.form({
                content: '',
                user_id: this.default_agent,
                time_spent: this.default_time,
                date: ''
            })
        }
    },
    computed: {
        default_time() {
            return (this.$page.props.timeOptions?.length) ? this.$page.props.timeOptions[0].id : null;
        },
        default_agent() {
            return (this.$page.props.agentOptions?.length) ? this.$page.props.agentOptions[0].id : null;
        },
        attachmentPath() {
            let date = new Date();
            return '/attachments/' + date.getFullYear() + '/' + (date.getMonth() + 1) + '/' + date.getDate();
        }
    },
    methods: {
        createJob() {
            this.form.post(route('tickets.jobs.store', this.ticket.id), {
                errorBag: 'createTicketJob',
                preserveScroll: true
            });
        },
    },
}
</script>
