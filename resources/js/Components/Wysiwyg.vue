<template>
    <div>
        <input :id="id" type="hidden" :value="trixText">
        <trix-editor ref="trix" :input="id" class="dark:text-gray-400 dark:bg-gray-900"></trix-editor>
    </div>
</template>
<script>
import Trix from 'trix'
import 'trix/dist/trix.css'

export default {
    props: ['id', 'modelValue', 'attachmentPath'],
    data() {
        return {
            trixText: this.modelValue
        }
    },
    methods: {
        setTextToTrix(e) {
            this.trixText = this.$refs.trix.value;
        },
        emitDataBackToComponent() {
            this.$emit("update:modelValue", this.trixText);
        },
        addAttachment(event) {
            let attachment = event.attachment;
            if (attachment.file) {
                return this.uploadAttachment(attachment);
            }
        },
        uploadAttachment(attachment) {
            let form = new FormData
            form.append("file", attachment.file)
            form.append('attachment-path', this.attachmentPath)

            const config = {
                headers:{'Content-Type' : 'multipart/form-data'},
                onUploadProgress: progressEvent => attachment.setUploadProgress(progressEvent.loaded / progressEvent.total * 100)
            }
            axios.post('/attach', form, config)
                .then(response => {
                    return attachment.setAttributes({
                        url: response.data.path,
                    })
                })
        }
    },
    mounted() {
        document.addEventListener('trix-attachment-add', this.addAttachment);
        document.addEventListener("trix-change", this.setTextToTrix);
    }
    ,
    beforeUnmount: function () {
        document.removeEventListener('trix-attachment-add', this.addAttachment)
        document.removeEventListener("trix-change", this.setTextToTrix);
    }
    ,
    updated() {
        this.emitDataBackToComponent();
    }

}
</script>
