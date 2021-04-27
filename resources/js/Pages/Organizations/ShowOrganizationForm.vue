<template>
    <jet-form-section>
        <template #title>
            Organization Information
        </template>

        <template #description>
            Organization information
        </template>

        <template #form>
            <!-- Content area -->
            <div class="flex-1 flex flex-col col-span-6">
                <main class="flex-1 overflow-y-auto focus:outline-none">
                    <div class="relative max-w-4xl mx-auto md:px-8 xl:px-0">
                        <div class="px-4 sm:px-6 md:px-0">
                            <div class="py-6">
                                <!-- Description list with inline editing -->
                                <div class="divide-y divide-gray-200">
                                    <dl>
                                        <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                            <dt class="text-sm font-medium text-gray-500">
                                                Organization Name
                                            </dt>
                                            <dd class="mt-1 flex text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                <span class="flex-grow" v-text="organization.name" />
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

        </template>
    </jet-form-section>
</template>
<script>
import JetFormSection from '@/Jetstream/FormSection'
export default {
    components: {
        JetFormSection
    },
    props: ['organization']
}
</script>
