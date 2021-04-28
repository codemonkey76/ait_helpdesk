<template>
    <div class="px-2 py-1 m-1 rounded-full text-white" :class="colorClass">
        <slot></slot>
    </div>
</template>
<script>
export default {
    props: {
        type: {
            type: String,
            default: 'success'
        }
    },
    computed: {
        colorClass() {
            let style="";
            switch (this.type) {
                case 'warning':
                    style = 'bg-yellow-500'
                    break
                case 'danger':
                    style = 'bg-red-500'
                    break;
                default:
                    style = 'bg-green-500'
            }
            return style
        }
    }
}
</script>
