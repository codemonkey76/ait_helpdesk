<template>
    <img class="h-8 w-8 rounded-full object-cover" :src="src" :alt="alt" />
</template>
<script>
export default {
    props: ['src', 'alt']
}
</script>
