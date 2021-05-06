<template>
    <nav class="dark:bg-gray-800 dark:border-gray-600 bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6" aria-label="Pagination">
        <div class="hidden sm:block">
            <p class="text-sm dark:text-gray-200 text-gray-700">
                Showing
                <span class="font-medium" v-text="data.from" />
                to
                <span class="font-medium" v-text="data.to" />
                of
                <span class="font-medium" v-text="data.total" />
                results
            </p>
        </div>
        <div class="flex-1 flex justify-between sm:justify-end">
            <a v-if="data.prev_page_url" :href="data.prev_page_url" class="relative inline-flex items-center px-4 py-2 border dark:border-gray-600 border-gray-300 text-sm font-medium rounded-md dark:text-gray-400 text-gray-700 dark:bg-gray-900 bg-white hover:bg-gray-800 hover:bg-gray-50">
                Previous
            </a>
            <a v-if="data.next_page_url" :href="data.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border dark:border-gray-600 border-gray-300 text-sm font-medium rounded-md dark:text-gray-400 text-gray-700 dark:bg-gray-900 bg-white hover:bg-gray-800 hover:bg-gray-50">
                Next
            </a>
        </div>
    </nav>
</template>
<script>
export default {
    props: ['data']
}
</script>
