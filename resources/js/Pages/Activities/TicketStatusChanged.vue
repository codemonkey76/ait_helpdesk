<template>
    <div class="dark:bg-gray-800 rounded-md shadow-lg dark:text-gray-400 py-2 px-4">
        <div class="text-sm italic" v-text="ago(statusChange.created_at)"></div>
        <div class="mt-2">
            {{ statusChange.user?.userType }}
            <span class="dark:text-gray-200" v-text="statusChange.userName" />
            changed the status of the ticket from
            <span :class="statusColor(statusChange.old_status_id)" v-text="statusChange.oldStatusName" />
            to
            <span :class="statusColor(statusChange.new_status_id)" v-text="statusChange.newStatusName" />
        </div>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    props: ['statusChange'],
    methods: {
        ago(date) {
            return new moment(date).fromNow()
        },
        statusColor(status) {
            switch (status) {
                case 1:
                    return 'text-red-400'
                case 2:
                    return 'text-green-400'
                case 3:
                    return 'text-red-400'
                case 4:
                    return 'text-brand-400'
                case 5:
                    return 'text-gray-500'
            }
        }
    }
}
</script>

<style scoped>

</style>
