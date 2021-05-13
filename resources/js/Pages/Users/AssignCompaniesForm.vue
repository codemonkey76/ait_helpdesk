<template>
    <jet-form-section>
        <template #title>
            Assign companies
        </template>
        <template #description>
            Assign all companies that this user will be able to create tickets on behalf of
        </template>
        <template #form>
            <div class="flex flex-col md:flex-row justify-between col-span-6 h-72">
                <div class="w-60">
                    <jet-label>Company List</jet-label>
                    <stacked-list ref="list"
                                  :data="companies"
                                  :grouped="true"
                                  title-field="name"
                                  subtitle-field="suburb"
                                  @selected="addItemSelected"
                                  :selected-item="addItem"
                    />
                </div>
                <div class="flex flex-col justify-center">
                    <jet-button @click="addCompanyToUser" class="justify-center my-1" :class="{ 'opacity-25': !this.addItem }" :disabled="!this.addItem">Add &gt;</jet-button>
                    <jet-button @click="removeCompanyFromUser" class="justify-center my-1" :class="{ 'opacity-25': !this.removeItem }" :disabled="!this.removeItem">&lt; Remove</jet-button>
                </div>
                <div class="w-60">
                    <jet-label>Assigned companies</jet-label>
                    <stacked-list
                        ref="assigned"
                        :grouped="false"
                        :data="user.companies"
                        title-field="name"
                        subtitle-field="suburb"
                        @selected="removeItemSelected"
                        :selected-item="removeItem"
                    ></stacked-list>
                </div>

            </div>
        </template>
    </jet-form-section>
</template>
<script>
import JetLabel from '@/Jetstream/Label'
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink'
import StackedList from "@/Jetstream/StackedList";

export default {
    components: {
        StackedList,
        JetFormSection,
        JetButton,
        JetLabel,
        JetSecondaryButtonLink
    },
    props: ['user', 'companies'],
    data() {
        return {

            addCompanyToUserForm: this.$inertia.form({
                _method: 'POST',
                company_id: this.addItem?.id
            }),
            removeCompanyFromUserForm: this.$inertia.form({
                _method: 'DELETE',
                company_id: this.removeItem?.id
            }),
            addItem: null,
            removeItem: null
        }
    },
    methods: {
        addItemSelected(item) {
            this.addItem = item
            this.addCompanyToUserForm.company_id = item.id
        },
        removeItemSelected(item) {
            this.removeItem = item
            this.removeCompanyFromUserForm.company_id = item.id
        },
        addCompanyToUser() {
            this.addCompanyToUserForm.post(route('users.companies.store', this.user.id),{
                errorBag: 'addCompanyToUser',
                preserveScroll: true,
                onSuccess: () => this.addItem = null
            })
        },
        removeCompanyFromUser() {
            console.log('calling removeCompanyFromUserForm.delete, with company_id: ' + this.removeItem?.id)
            this.removeCompanyFromUserForm.delete(route('users.companies.destroy', this.user.id),{
                errorBag: 'removeCompanyFromUser',
                preserveScroll: true,
                onSuccess: () => this.removeItem = null
            })
        }
    }
}
</script>
