<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl dark:text-gray-400 text-gray-800 leading-tight">
                Phone Verification
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <phone-verification-form :user="$page.props.user"></phone-verification-form>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import PhoneVerificationForm from "@/Pages/Phone/PhoneVerificationForm";
export default {
    components: {PhoneVerificationForm, AppLayout}
}
</script>

<style scoped>

</style>
