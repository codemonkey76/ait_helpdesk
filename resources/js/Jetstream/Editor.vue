<template>
    <div>
        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig" />
        <input id="content" name="content" type="hidden" :value="editorData"/>
    </div>
</template>

<script>

import InlineEditor from '@ckeditor/ckeditor5-build-classic'
export default {
    name: "Editor",
    props: ['modelValue'],
    watch: {
        editorData() {
            this.$emit('update:modelValue', this.editorData);
        }
    },
    data() {
        return {
            editor: InlineEditor,
            editorData: this.modelValue,
            editorConfig: {

            }
        }
    },
}
</script>

<style scoped>

</style>
