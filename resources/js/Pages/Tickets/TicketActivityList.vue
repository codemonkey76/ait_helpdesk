<template>
    <div>
        <div v-if="!activities || !activities.length" class="text-center dark:text-gray-400 text-gray-500 italic">
            No activity at this time
        </div>
        <div v-else v-for="activity in activities">


        </div>

    </div>
</template>

<script>
export default {
    props: ['activities']
}
</script>
