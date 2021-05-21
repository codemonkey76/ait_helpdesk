<template>
    <tr class="dark:odd:bg-gray-700 dark:even:bg-gray-800 odd:bg-white even:bg-gray-50 dark:text-gray-300 text-gray-500">
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            <a class="dark:text-blue-400 dark:hover:text-blue-200 text-blue-500" :href="route('tickets.show', ticket.id)" v-text="ticket.id"/>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm" :class="{'font-bold': unread, 'italic dark:text-gray-500 text-gray-300': closed}">
            <user-tag :user="ticket.user"/>
        </td>
        <td class="px-6 py-4 text-sm" :class="{'font-bold': unread, 'italic dark:text-gray-500 text-gray-300': closed}"
            v-text="ticket.subject"/>
        <td class="px-6 py-4 text-sm" :class="{'font-bold': unread, 'italic dark:text-gray-500 text-gray-300': closed}"
            v-text="ticket.excerpt"/>
        <td class="px-6 py-4 whitespace-nowrap text-sm" :class="{'font-bold': unread, 'italic dark:text-gray-500 text-gray-300': closed}"
            v-text="ago(ticket.updated_at)"/>
        <td class="px-6 py-4 whitespace-nowrap text-sm" :class="{'font-bold': unread, 'italic dark:text-gray-500 text-gray-300': closed}"
            v-text="ticket.company_name"/>
        <td class="px-6 py-4 whitespace-nowrap text-sm">
            <jet-toggle class="rounded-md" @click="toggleSubscribe" :active="ticket.isSubscribed">
            <svg aria-hidden="true" data-prefix="fas" data-icon="bell"
                 class="h-4 w-5" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 448 512">
                <path fill="currentColor"
                      d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z"/>
            </svg>
                <input type="hidden" v-model="subscribeForm.ticket_id">
            </jet-toggle>
        </td>
    </tr>
</template>
<script>
import UserTag from "@/Pages/Users/UserTag"
import moment from "moment"
import JetToggle from '@/Jetstream/ToggleButton'
import JetButton from '@/Jetstream/Button'

export default {
    components: {
        UserTag,
        JetButton,
        JetToggle
    },
    props: ['ticket'],
    data() {
        return {
            subscribeForm: this.$inertia.form({
                ticket_id: this.ticket.id
            })
        }
    },
    methods: {
        ago(date) {
            return moment(date).fromNow()
        },
        toggleSubscribe() {
            if (! this.ticket.isSubscribed) {
                this.subscribeForm.post(route('tickets.subscribe', this.ticket.id), {
                    errorBag: 'ticketSubscription',
                    preserveScroll: true
                })
            } else {
                this.subscribeForm.delete(route('tickets.unsubscribe', this.ticket.id), {
                    errorBag: 'ticketSubscription',
                    preserveScroll: true
                })
            }
        }
    },
    computed: {
        unread() {
            return !this.ticket.readers?.find(x => x?.id === this.$page.props.user.id)
        },
        closed() {
            return this.ticket.status?.final
        }
    }
}
</script>
