<template>
    <jet-form-section @submitted="createOrganization">
        <template #title>
            Company Details
        </template>

        <template #description>
            Edit company.
        </template>

        <template #form>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Company Name"/>
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus/>
                <jet-input-error :message="form.errors.name" class="mt-2"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="phone" value="Phone"/>
                <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" autofocus/>
                <jet-input-error :message="form.errors.phone" class="mt-2"/>
            </div>


            <div class="col-span-6 sm:col-span-4">
                <jet-label for="address" value="Address Line 1"/>
                <jet-input id="address" type="text" class="mt-1 block w-full" v-model="form.address" autofocus/>
                <jet-input-error :message="form.errors.address" class="mt-2"/>
            </div>


            <div class="col-span-6 sm:col-span-4">
                <jet-label for="address2" value="Address Line 2"/>
                <jet-input id="address2" type="text" class="mt-1 block w-full" v-model="form.address2" autofocus/>
                <jet-input-error :message="form.errors.address2" class="mt-2"/>
            </div>


            <div class="col-span-6 sm:col-span-4">
                <jet-label for="suburb" value="Suburb"/>
                <jet-input id="suburb" type="text" class="mt-1 block w-full" v-model="form.suburb" autofocus/>
                <jet-input-error :message="form.errors.suburb" class="mt-2"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="state" value="State"/>
                <jet-input id="state" type="text" class="mt-1 block w-full" v-model="form.state" autofocus/>
                <jet-input-error :message="form.errors.state" class="mt-2"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="postcode" value="Postcode"/>
                <jet-input id="postcode" type="text" class="mt-1 block w-full" v-model="form.postcode" autofocus/>
                <jet-input-error :message="form.errors.postcode" class="mt-2"/>
            </div>

            <jet-select class="col-span-6 sm:col-span-4"
                        :options="$page.props.organizationOptions"
                        v-model="form.organization_id">
                <template #none-selected>
                    <option :value="null">None selected</option>
                </template>
            </jet-select>


        </template>

        <template #actions>
            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetSelect from '@/Jetstream/Select'
import JetDangerButton from "../../Jetstream/DangerButton";

export default {
    components: {
        JetDangerButton,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSelect
    },
    props: ['company'],

    data() {

        return {
            form: this.$inertia.form({
                _method: 'PUT',
                name: this.company.name,
                phone: this.company.phone,
                address: this.company.address,
                address2: this.company.address2,
                suburb: this.company.suburb,
                state: this.company.state,
                postcode: this.company.postcode,
                organization_id: this.company.organization_id
            })
        }
    },

    methods: {
        createOrganization() {
            this.form.post(route('companies.update', this.company.id), {
                errorBag: 'updateCompany',
                preserveScroll: true
            });
        },
    },
}
</script>
