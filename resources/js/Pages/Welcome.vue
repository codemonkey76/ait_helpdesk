<template>
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <jet-button-link v-if="$page.props.user" href="/dashboard">Dashboard</jet-button-link>
            <template v-else>
                <jet-button-link :href="route('login')">Login</jet-button-link>
                <jet-secondary-button-link v-if="canRegister" class="ml-2" :href="route('register')">Register
                </jet-secondary-button-link>
            </template>
<!--            <inertia-link v-if="$page.props.user" href="/dashboard" class="text-sm text-gray-700 dark:text-gray-500">-->
<!--                Dashboard-->
<!--            </inertia-link>-->

<!--            <template v-else>-->
<!--                <inertia-link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500">-->
<!--                    Log in-->
<!--                </inertia-link>-->

<!--                <inertia-link v-if="canRegister" :href="route('register')"-->
<!--                              class="ml-4 text-sm text-gray-700 dark:text-gray-500">-->
<!--                    Register-->
<!--                </inertia-link>-->
<!--            </template>-->
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!--            <div class="flex justify-between">-->
            <!--                <application-mark class="h-8"></application-mark>-->
            <!--                <div class="flex">-->

            <!--                </div>-->

                            <application-logo class="hidden sm:block h-16 my-2"></application-logo>
            <!--            </div>-->
            <div class="flex sm:hidden justify-between p-4 items-center">
                <div>
                    <application-mark class="h-12"></application-mark>
                </div>
                <div>

                    <jet-button-link v-if="$page.props.user" href="/dashboard">Dashboard</jet-button-link>
                    <template v-else>
                        <jet-button-link :href="route('login')">Login</jet-button-link>
                        <jet-secondary-button-link v-if="canRegister" class="ml-2" :href="route('register')">Register
                        </jet-secondary-button-link>
                    </template>
                </div>
            </div>

            <div class="mt-0 md:mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <info-card class="bg-brand-600">
                        <template #image>
                            <img class="w-16 h-16" src="/images/business-support.png" alt="Business support"/>
                        </template>
                        <template #title>
                            <a href="https://www.alphaitcentre.com.au/managed-services/"
                               class="underline text-gray-200">
                                Business Support
                            </a>
                        </template>
                        <template #body>
                            <p class="text-gray-400">
                                Big or small, your business is as good as the processes and systems you put in
                                place. Increase your efficiency and reduce ongoing costs with the tech needed in
                                your business with AlphaIT's network design. No matter the nature and size of your
                                company, we can design a network that will cater to your network management,
                                procurement, implementation, maintenance, and installation of operating tools and
                                software.
                            </p>
                        </template>
                    </info-card>
                    <info-card
                        class="dark:bg-gray-800 bg-gray-200 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                        <template #image>
                            <img src="/images/domain-services.png" class="h-16 w-16" alt="Domain Services">
                        </template>
                        <template #title>
                            <a href="https://www.alphaitcentre.com.au/domain-name-registration/"
                               class="underline text-gray-900 dark:text-white">
                                Domain Services</a>
                        </template>
                        <template #body>
                            Whether you're starting an online store or a personal blog, having your own .com or
                            .com.au website builds trust more than a URL with a CMS extension. While services like
                            WordPress are known to be reliable, a company without its own domain name still makes
                            for a shady online business identity. Be a domain owner with full control of your
                            website with Alpha IT, making management, security, and maintenance easy as pie.
                        </template>
                    </info-card>
                    <info-card class="border-t border-gray-200 dark:border-gray-700 dark:bg-gray-800 bg-gray-200">
                        <template #image>
                            <img src="/images/hosting-services.png" class="h-16 w-16" alt="Domain Services">
                        </template>
                        <template #title>
                            <a href="https://www.alphaitcentre.com.au/website-hosting/"
                               class="underline text-gray-900 dark:text-white">
                                Hosting Services
                            </a>
                        </template>
                        <template #body>
                            In today's world of online consumers, a website and corporate email address is a must to
                            showcase your products and services, and handle customer enquiries. Have your website
                            and email hosted with us contract free, and we'll provide you with all the key web
                            features. As your business grows, Alpha IT can tailor web hosting, domain registration,
                            web design, email hosting, data recovery plans, and advertising packages to match your
                            needs.
                        </template>
                    </info-card>
                    <info-card
                        class="dark:bg-gray-800 bg-gray-200 border-t border-gray-200 dark:border-gray-700 md:border-l">
                        <template #image>
                            <img src="/images/data-centre.png" class="h-16 w-16" alt="Data Centre">
                        </template>
                        <template #title>
                            <a href="https://www.alphaitcentre.com.au/virtual-servers/"
                               class="underline text-gray-900 dark:text-white">
                                Data Centre
                            </a>
                        </template>
                        <template #body>
                            With physically networked servers being too expensive or impractical, a virtual private
                            network becomes the perfect solution for your business. AlphaIT offers an affordable
                            solution that gives you the flexibility of dedicated server hosting and eliminates the
                            limitations of shared hosting. Get only a single physical server to form multiple
                            virtual servers independent of each other whilst having your system function like an
                            actual networked server.
                        </template>
                    </info-card>
                </div>
            </div>

            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.bg-gray-100 {
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
}

.border-gray-200 {
    border-color: #edf2f7;
    border-color: rgba(237, 242, 247, var(--tw-border-opacity));
}

.text-gray-400 {
    color: #cbd5e0;
    color: rgba(203, 213, 224, var(--tw-text-opacity));
}

.text-gray-500 {
    color: #a0aec0;
    color: rgba(160, 174, 192, var(--tw-text-opacity));
}

.text-gray-600 {
    color: #718096;
    color: rgba(113, 128, 150, var(--tw-text-opacity));
}

.text-gray-700 {
    color: #4a5568;
    color: rgba(74, 85, 104, var(--tw-text-opacity));
}

.text-gray-900 {
    color: #1a202c;
    color: rgba(26, 32, 44, var(--tw-text-opacity));
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-gray-800 {
        background-color: #2d3748;
        background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
    }

    .dark\:bg-gray-900 {
        background-color: #1a202c;
        background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
    }

    .dark\:border-gray-700 {
        border-color: #4a5568;
        border-color: rgba(74, 85, 104, var(--tw-border-opacity));
    }

    .dark\:text-white {
        color: #fff;
        color: rgba(255, 255, 255, var(--tw-text-opacity));
    }

    .dark\:text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }
}
</style>

<script>
import ApplicationLogo from "@/Jetstream/ApplicationLogo";
import ApplicationMark from "@/Jetstream/ApplicationMark"
import InfoCard from "@/Jetstream/InfoCard";
import JetButton from "@/Jetstream/Button";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetButtonLink from '@/Jetstream/ButtonLink';
import JetSecondaryButtonLink from '@/Jetstream/SecondaryButtonLink';

export default {
    components: {
        InfoCard,
        ApplicationLogo,
        ApplicationMark,
        JetButton,
        JetSecondaryButton,
        JetButtonLink,
        JetSecondaryButtonLink
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    }
}
</script>
