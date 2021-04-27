<template>
    <div class="mt-10 sm:mt-0">
        <div v-if="!notes.data.length" class="mt-10 italic text-gray-500">No notes to show</div>
        <note-card v-for="(note,key) in notes.data" :key="key" :note="note"/>
        <jet-paginator v-if="notes.data.length" :data="notes"></jet-paginator>
    </div>
</template>
<script>
import NoteCard from './NoteCard'
import JetPaginator from '@/Jetstream/Paginator'

export default {
    components: {
        NoteCard,
        JetPaginator
    },
    props: ['notes']
}
</script>
