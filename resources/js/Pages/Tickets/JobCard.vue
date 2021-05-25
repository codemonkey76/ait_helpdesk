<template>
    <div class="dark:bg-gray-800 bg-white text-gray-600 rounded-md shadow-lg dark:text-gray-400 py-2 px-4">
        <div class="dark:text-gray-200 text-gray-800">
            Job Card
        </div>
        <div class="my-2 dark:bg-gray-900 bg-gray-100 py-2 px-4 rounded-md">
            <div>
                <pre>{{jobCard.content}}</pre>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['jobCard']
}
</script>
