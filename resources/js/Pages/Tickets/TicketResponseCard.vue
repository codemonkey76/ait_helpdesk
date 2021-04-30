<template>
    <div class="bg-white pt-10 pb-10 px-4 sm:px-6 lg:px-8 rounded-md shadow-lg">
        <div class="relative max-w-lg mx-auto divide-y-2 divide-gray-200 lg:max-w-7xl">
            <div>
                <h2 class="text-xl tracking-tight font-extrabold text-gray-900 sm:text-2xl">
                    Response #<span v-text="response.id"></span>
                </h2>
                <p class="mt-3 text-lg text-gray-500 sm:mt-4" v-text="response.subject"/>
            </div>
            <div class="mt-4 pt-6">
                <div>
                    <a href="#" class="block mt-4">
                        <p class="mt-3 text-base text-gray-500" v-text="response.content"/>
                    </a>
                    <div class="mt-4 flex items-center">
                        <div class="flex-shrink-0">
                            <a href="#">
                                <span class="sr-only" v-text="response.user?.name" />
                                <img class="h-10 w-10 rounded-full"
                                     :src="response.user?.profile_photo_url"
                                     alt="">
                            </a>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900" v-text="response.user?.name" />
                            <div class="flex space-x-1 text-sm text-gray-500">
                                <span v-text="ago(response.created_at)" />
                                <span aria-hidden="true">&middot;</span>
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
import moment from 'moment'
export default {
    props: ['response'],
    methods: {
        ago(date) {
            return moment(date).fromNow()
        }
    },
    computed: {
        readText() {
            return (this.response.agent_read_at) ? moment(this.response.agent_read_at).fromNow() : 'unread'
        }
    }
}
</script>
