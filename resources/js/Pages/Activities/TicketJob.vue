<template>
    <div class="dark:bg-gray-800 rounded-md shadow-lg dark:text-gray-400 py-2 px-4">
        <div class="text-sm italic" v-text="ago(job.created_at)"></div>
        <div class="mt-2">
            {{ job.user?.userType }}
            <span class="dark:text-gray-200" v-text="job.userName" />
            added a job

            <div class="mt-2 dark:bg-gray-900 py-2 px-4 rounded-md">
                <div v-text="job.content" />

                <div>
                    Time allocated: {{job.timeSpentString}}
                </div>

            </div>

        </div>
    </div>
</template>
<script>
import moment from 'moment'
export default {
    props: ['job'],
    methods: {
        ago(date) {
            return new moment(date).fromNow()
        }
    }

}
</script>
