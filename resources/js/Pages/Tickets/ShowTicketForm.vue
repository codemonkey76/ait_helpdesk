<template>
    <div class="bg-white pt-16 pb-16 px-4 sm:px-6 lg:px-8 rounded-md shadow-lg">
        <div class="relative max-w-lg mx-auto divide-y-2 divide-gray-200 lg:max-w-7xl">
            <div>
                <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">
                    Ticket #<span v-text="ticket.id"></span>
                </h2>
                <p class="mt-3 text-xl text-gray-500 sm:mt-4" v-text="ticket.subject"/>
            </div>
            <div class="mt-4 pt-12">
                <div>
                    <a href="#" class="block mt-4">
                        <p class="mt-3 text-base text-gray-500" v-text="ticket.content"/>
                    </a>
                    <div class="mt-6 flex items-center">
                        <div class="flex-shrink-0">
                            <a href="#">
                                <span class="sr-only" v-text="ticket.user?.name" />
                                <img class="h-10 w-10 rounded-full"
                                     :src="ticket.user.profile_photo_url"
                                     alt="">
                            </a>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900" v-text="ticket.user?.name" />
                            <div class="flex space-x-1 text-sm text-gray-500">
                                <time datetime="2020-03-16">
                                    Mar 16, 2020
                                </time>
                                <span aria-hidden="true">
                &middot;
              </span>
                                <span>
                6 min read
              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    props: ['ticket']
}
</script>
