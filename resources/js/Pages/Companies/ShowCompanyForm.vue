<template>
    <jet-form-section>
        <template #title>
            Company Information
        </template>

        <template #description>
            Company information
        </template>

        <template #form>
            <!-- Profile Photo -->


            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" autocomplete="name" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" />
            </div>
        </template>
    </jet-form-section>
</template>
<script>
import JetFormSection from '@/Jetstream/FormSection'
import JetLabel from '@/Jetstream/Label'
import JetInput from '@/Jetstream/Input'
export default {
    components: {
        JetFormSection,
        JetLabel,
        JetInput
    }
}
</script>
