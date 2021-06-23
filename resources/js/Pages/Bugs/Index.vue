<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl dark:text-gray-400 text-gray-800 leading-tight">
                Bugs
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex w-full items-center">
                    <jet-button-link :href="route('bugs.create')">
                        Report
                    </jet-button-link>
                    <jet-search class="ml-4 w-full" :search-route="route('bugs.index')"
                                :search="$page.props.q"></jet-search>
                </div>
                <bug-list :bugs="$page.props.bugs"/>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from "../../Layouts/AppLayout"
import BugList from "./BugList"
import JetSearch from '../../Jetstream/Search'
import JetButtonLink from '../../Jetstream/ButtonLink'

export default {
    components: {
        BugList,
        AppLayout,
        JetSearch,
        JetButtonLink
    }
}
</script>
