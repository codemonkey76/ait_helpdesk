<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl dark:text-gray-400 text-gray-800 leading-tight">
                Test Form
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <jet-form-section @submitted="submitForm">
                        <template #title>
                            Title
                        </template>
                        <template #description>
                            Description
                        </template>
                        <template #form>
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label value="Communication Preferences"/>
                                <label class="flex items-center">
                                    <jet-checkbox @update:checked="updated" name="prefs" v-model:checked="form.email_pref" />
                                    <span class="ml-2 text-sm dark:text-gray-200 text-gray-400">Email</span>
                                </label>
                                <label class="flex items-center">
                                    <jet-checkbox name="prefs" v-model:checked="form.sms_pref" />
                                    <span class="ml-2 text-sm dark:text-gray-200 text-gray-400">SMS</span>
                                </label>
                            </div>
                        </template>
                        <template #actions>
                            <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Submit
                            </jet-button>
                        </template>

                    </jet-form-section>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import JetCheckbox from "@/Jetstream/Checkbox";
import JetFormSection from "@/Jetstream/FormSection";
import JetInputError from "@/Jetstream/InputError";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import AppLayout from "@/Layouts/AppLayout";

export default {
    components: {
        JetButton,
        JetCheckbox,
        JetInput,
        JetInputError,
        JetLabel,
        JetFormSection,
        AppLayout
    },
    data() {
        return {
            form: this.$inertia.form({
                email_pref: false,
                sms_pref: false
            }),
        }
    },
    methods: {
        updated() {

        },
        submitForm() {
            this.form.post(route('test.store'))
        }
    }
}
</script>

<style scoped>

</style>
