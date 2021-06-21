<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="bg-white px-4 py-5 sm:px-6 mt-2">
        <div class="flex space-x-3">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" :src="note.user.profile_photo_url" alt="">
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-gray-900 flex">
                    <a href="#" class="hover:underline" v-text="note.user.name"/>
                    <div v-if="note.is_favorite" class="ml-2">
                        <svg class="mr-3 h-5 w-5 text-yellow-400"
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                </p>
                <p class="text-sm text-gray-500">
                    <a href="#" class="hover:underline" v-text="ago(note.created_at)"></a>
                </p>
                <div class="text-sm font-medium text-gray-900 mt-2" v-html="note.content"/>
            </div>
            <div class="flex-shrink-0 self-start flex">
                <div class="relative z-30 inline-block text-left">
                    <div>
                        <button @click="toggleMenu" type="button"
                                class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600"
                                id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open options</span>
                            <!-- Heroicon name: solid/dots-vertical -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 fill="currentColor" aria-hidden="true">
                                <path
                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                            </svg>
                        </button>
                    </div>

                    <transition enter-class="transition ease-out duration-100 transform"
                                enter-from="opacity-0 scale-95"
                                enter-to-class="opacity-100 scale-100"
                                leave="transition ease-in duration-75 transform"
                                leave-from-class="opacity-100 scale-1">
                        <div v-show="menuOpen"
                             class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                             role="menu" aria-orientation="vertical" aria-labelledby="menu-0-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <a @click="favoriteNote" href="#"
                                   :class="{ 'bg-gray-100 text-gray-900': note.is_favorite, 'text-gray-700': !note.is_favorite}"
                                   class="flex px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                                   id="menu-0-item-0">
                                    <!-- Heroicon name: solid/star -->
                                    <svg :class="{'text-gray-400': !note.is_favorite, 'text-yellow-400': note.is_favorite}"
                                         class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span v-show="!note.is_favorite">Add to favourites</span>
                                    <span v-show="note.is_favorite">Remove from favourites</span>
                                </a>
                                <a href="#" v-show="$page.props.permissions.canEditNotes" @click="showEditModal" class="text-gray-700 flex px-4 py-2 text-sm" role="menuitem">
                                    <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 74.16l-60.09-60.1c-18.75-18.75-49.19-18.75-67.93 0L313.4 70.61l127.1 128 56.56-56.55c19.64-18.76 19.64-49.15.84-67.9zM31.04 352.1a16.01 16.01 0 00-4.377 8.176l-26.34 131.7C-1.703 502.1 6.156 512 15.95 512c1.049 0 2.117-.103 3.199-.32l131.7-26.34a16.009 16.009 0 008.176-4.373l259.7-259.7-128-128L31.04 352.1zm100.86 88.1l-75.14 15.03 15.03-75.15L96 355.9V416h60.12l-24.22 24.2z"/></svg>
                                    <span>Edit</span>
                                </a>
                                <a v-show="$page.props.permissions.canDeleteNotes" @click="confirmNoteDeletion" href="#" class="text-gray-700 flex px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                                   id="menu-0-item-1">
                                    <!-- Heroicon name: solid/code -->
                                    <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>

                                    <span>Delete</span>
                                </a>

                                <jet-dialog-modal :show="editingNote" @close="editingNote = false">
                                    <template #title>
                                        Edit Note
                                    </template>

                                    <template #content>
                                        <div class="mt-4">

                                            <jet-label for="content" value="Note content" />
                                            <editor id="content" ref="content" v-model="editingForm.content" />
                                            <jet-input-error :message="editingForm.errors.content" class="mt-2"/>
                                        </div>
                                    </template>

                                    <template #footer>
                                        <jet-secondary-button @click="editingNote = false">
                                            Cancel
                                        </jet-secondary-button>

                                        <jet-button class="ml-2" @click="editNote" :class="{ 'opacity-25': editingForm.processing }"
                                                    :disabled="editingForm.processing">
                                            Save Note
                                        </jet-button>
                                    </template>
                                </jet-dialog-modal>

                                <jet-confirmation-modal :show="confirmingNoteDeletion" @close="confirmingNoteDeletion = false">
                                    <template #title>
                                        Delete Note
                                    </template>

                                    <template #content>
                                        Are you sure you want to delete this note? Once a note is deleted, it cannot be recovered.
                                    </template>

                                    <template #footer>
                                        <jet-secondary-button @click="confirmingNoteDeletion = false">
                                            Cancel
                                        </jet-secondary-button>

                                        <jet-danger-button class="ml-2" @click="deleteNote" :class="{ 'opacity-25': deleteForm.processing }" :disabled="deleteForm.processing">
                                            Delete Note
                                        </jet-danger-button>
                                    </template>
                                </jet-confirmation-modal>



                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import JetConfirmationModal from "@/Jetstream/ConfirmationModal"
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetButton from '@/Jetstream/Button'
import JetLabel from '@/Jetstream/Label'
import JetInputError from '@/Jetstream/InputError'
import JetDialogModal from '@/Jetstream/DialogModal'
import Editor from '@/Jetstream/Editor'
import moment from 'moment'

export default {
    components: {
        JetConfirmationModal,
        JetSecondaryButton,
        JetDangerButton,
        JetButton,
        JetLabel,
        JetInputError,
        Editor,
        JetDialogModal
    },
    props: ['note'],
    data() {
        return {
            confirmingNoteDeletion: false,
            editingNote: false,
            menuOpen: false,
            editingForm: this.$inertia.form({
                _method: 'PATCH',
                content: this.note.content
            }),
            form: this.$inertia.form({
                    _method: 'POST',
                }),
            deleteForm: this.$inertia.form({
                _method: 'DELETE',
            })
        }
    },
    methods: {
        toggleMenu() {
            this.menuOpen = !this.menuOpen;
        },
        ago(date) {
            return moment(date).fromNow();
        },
        favoriteNote() {
            this.menuOpen = false;
            if (this.note.is_favorite) {
                this.deleteForm.delete(route('notes.favorite.destroy', this.note.id), {
                    errorBag: 'unfavoriteNote',
                    preserveScroll: true
                });
                return;
            }

            this.form.post(route('notes.favorite.store', this.note.id), {
                errorBag: 'favoriteNote',
                preserveScroll: true
            });

        },
        confirmNoteDeletion() {
            this.menuOpen = false
            this.confirmingNoteDeletion = true
        },
        closeDeleteModal() {
            this.confirmingNoteDeletion = false
        },
        closeEditModal() {
            this.editingnote = false;
        },
        showEditModal() {
            this.menuOpen = false
            this.editingNote = true
        },
        editNote() {
            this.editingForm.patch(route('notes.update', this.note.id), {
                errorBag: 'editNote',
                preserverScroll: true,
                onSuccess: () => this.closeEditModal()
            })
        },
        deleteNote() {
            this.deleteForm.delete(route('notes.destroy', this.note.id), {
                errorBag: 'deleteNote',
                preserveScroll: true,
                onSuccess: () => this.closeDeleteModal(),
            })
        },
    },
}
</script>
