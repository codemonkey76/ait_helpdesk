<template>
    <div class="flex items-center">
        <jet-avatar :src="user.profile_photo_url" :alt="user.name"/>
        <a class="ml-2" :class="{'dark:text-blue-400 dark:hover:text-blue-200 text-blue-500': linkActive}" :href="href"
           v-text="user.name"/>
    </div>
</template>
<script>
import JetAvatar from '@/Jetstream/Avatar'
export default {
    components: {JetAvatar},
    props: {
        user: {
            type: Object
        },
        href: {
            type: String,
            default: null
        }
    },
    computed: {
        linkActive() {
            return ! ! this.href;
        }
    }
}
</script>
