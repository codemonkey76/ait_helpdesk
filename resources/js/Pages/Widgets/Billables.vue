<template>
    <div class="dark:bg-gray-800 bg-white overflow-hidden shadow-xl sm:rounded-lg divide-y divide-gray-600 m-2">
        <div class="px-4 py-3 sm:px-6 dark:text-gray-200">
            Billable hours (last 7 days)
        </div>
        <div class="px-4 py-5 sm:p-6 dark:text-gray-400">
            <div v-if="!billableHours">
                no users found
            </div>

            <table v-else>
                <thead>
                    <tr>
                        <th class="text-left">Name</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in billableHours">
                            <td class="text-left" v-text="user.name" />
                            <td class="text-center" v-text="user.total" />
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>
<script>
export default {
    props: ['billableHours']
}
</script>
