<template>
    <a :href="href" class="inline-flex items-center px-4 py-2 bg-brand-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 active:bg-brand-900 focus:outline-none focus:border-brand-900 focus:ring focus:ring-brand-300 disabled:opacity-25 transition">
        <slot></slot>
    </a>
</template>

<script>
    export default {
        props: ['href']
    }
</script>
