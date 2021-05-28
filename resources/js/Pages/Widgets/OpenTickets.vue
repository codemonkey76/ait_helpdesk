<template>
    <div class="dark:bg-gray-800 bg-white overflow-hidden shadow-xl sm:rounded-lg divide-y divide-gray-600 m-2">
        <div class="px-4 py-3 sm:px-6 dark:text-gray-200">
            Open tickets
        </div>
        <div class="px-4 py-5 sm:p-6 dark:text-gray-400">
            <div class="text-4xl" v-text="openTickets" />
        </div>
    </div>
</template>
<script>
export default {
    props: ['openTickets']
}
</script>
