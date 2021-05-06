<template>
    <div>
        <div class="p-6 sm:px-20 dark:bg-gray-800 bg-white">
            <div>
                <jet-application-logo class="block h-12 w-auto"/>
            </div>

            <div class="mt-8 text-2xl dark:text-gray-200">
                Welcome to the Alpha IT Centre Helpdesk
            </div>

            <div class="mt-6 dark:text-gray-400 text-gray-500">
                Use this system to lodge a request for assistance, one of our friendly staff will endeavor to help as
                soon as possible. Please choose which team you would like to direct your request to in the top right
                corner.
            </div>
        </div>
    </div>
</template>

<script>
import JetApplicationLogo from '@/Jetstream/ApplicationLogo'

export default {
    components: {
        JetApplicationLogo,
    },
}
</script>
