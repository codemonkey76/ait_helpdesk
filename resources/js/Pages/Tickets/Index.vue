<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tickets
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex w-full items-center">
                    <jet-button-link :href="route('tickets.create')">
                        Create
                    </jet-button-link>
                    <jet-search class="ml-4 w-full" :search-route="route('tickets.index')" :search="$page.props.q"></jet-search>
                </div>
                <div class="w-full flex justify-center">
                    <jet-button-group class="my-1">
                        <jet-toggle-button @click="allFilters" class="rounded-l-md" :model-value="allFiltersSelected">All</jet-toggle-button>
                        <jet-toggle-button class="rounded-none -ml-px" v-model="form.filters.pending">Pending</jet-toggle-button>
                        <jet-toggle-button class="rounded-none -ml-px" v-model="form.filters.open">Open</jet-toggle-button>
                        <jet-toggle-button class="rounded-none -ml-px" v-model="form.filters.waiting">Waiting</jet-toggle-button>
                        <jet-toggle-button class="rounded-none -ml-px" v-model="form.filters.billing">Billing</jet-toggle-button>
                        <jet-toggle-button class="rounded-r-md -ml-px" v-model="form.filters.closed">Closed</jet-toggle-button>
                    </jet-button-group>
                </div>
                <ticket-list :tickets="$page.props.tickets"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
import JetToggleButton from '@/Jetstream/ToggleButton'
import JetButtonGroup from "@/Jetstream/ButtonGroup";
import JetButtonLink from '@/Jetstream/ButtonLink'
import AppLayout from '@/Layouts/AppLayout'
import JetSearch from '@/Jetstream/Search'
import TicketList from "@/Pages/Tickets/TicketList";

export default {
    components: {
        JetButtonGroup,
        JetToggleButton,
        TicketList,
        AppLayout,
        JetButtonLink,
        JetSearch,
    },
    watch: {
      'form.filters': {
          deep:true,

          handler() {
              console.log('patching /api/user/filters')
              this.form.patch('/user/filters',{
                  errorBag: 'userFilters',
                  preserveScroll: true
              })
          }
      }
    },
    data() {
        return {
            form: this.$inertia.form({
                filters: this.$page.props.user.filters
            })

        }
    },
    methods: {
        allFilters() {
            this.form.filters.pending = true;
            this.form.filters.open = true;
            this.form.filters.waiting = true;
            this.form.filters.billing = true;
            this.form.filters.closed = true;
        }
    },
    computed: {
        allFiltersSelected() {
            return this.form.filters.pending &&
                this.form.filters.open &&
                this.form.filters.waiting &&
                this.form.filters.billing &&
                this.form.filters.closed
        }
    }
}
</script>
