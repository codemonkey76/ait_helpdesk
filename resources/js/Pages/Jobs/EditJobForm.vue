<template>
    <jet-form-section @submitted="updateJob">
        <template #title>
            Job Details
        </template>

        <template #description>
            Edit job
        </template>

        <template #form>

            <div class="col-span-6">
                <jet-label for="content" value="Content"/>
                <editor id="content" v-model="form.content"></editor>
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
            <jet-secondary-button-link :href="route('tickets.index')">Cancel</jet-secondary-button-link>
            <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
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

export default {
    components: {
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
    props: ['job', 'ticket'],
    data() {
        return {
            form: this.$inertia.form({
                content: this.job.content,
                user_id: this.job.user_id,
                time_spent: this.job.time_spent,
                date: this.job.date
            })
        }
    },
    computed: {
        default_time() {
            return (this.$page.props.timeOptions?.length) ? this.$page.props.timeOptions[0].id : null;
        },
        default_agent() {
            return (this.$page.props.agentOptions?.length) ? this.$page.props.agentOptions[0].id : null;
        }
    },
    methods: {
        updateJob() {
            this.form.post(route('tickets.jobs.update', [this.ticket.id, this.job.id]), {
                errorBag: 'updateTicketJob',
                preserveScroll: true
            });
        },
    },
}
</script>
