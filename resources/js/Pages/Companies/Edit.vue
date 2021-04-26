<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit company
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <edit-company-form :company="$page.props.company"/>

                    <jet-section-border />
                </div>
                <div>
                    <delete-company-form  class="mt-10 sm:mt-0" :company="$page.props.company"/>

                    <jet-section-border />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import EditCompanyForm from './EditCompanyForm'
import DeleteCompanyForm from "./DeleteCompanyForm";
import JetSectionBorder from '@/Jetstream/SectionBorder'

export default {
    components: {
        AppLayout,
        EditCompanyForm,
        DeleteCompanyForm,
        JetSectionBorder
    },
}
</script>
